<?php

namespace App\Http\Controllers;

use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Controller สำหรับระบบแสดงผลและตรวจสอบบันทึกกิจกรรม (Audit Log)
 * 
 * ฟังก์ชันหลัก:
 * - แสดงหน้า Dashboard สำหรับตรวจสอบประวัติการใช้งาน
 * - รองรับการค้นหาและกรองข้อมูลตามช่วงเวลา, ประเภท Action, ตาราง และคำค้นหา
 * - แสดงสรุปยอดสถิติ (Summary Cards)
 * - แสดงรายละเอียดข้อมูล JSON (Old / New Values)
 */
class AuditLogController extends Controller
{
    /**
     * กำหนด Middleware ให้ต้องผ่านการ Login ก่อน
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * แสดงหน้าหลักของระบบบันทึกกิจกรรม (Audit Log Dashboard)
     *
     * @return View
     */
    public function index(): View
    {
        // ดึงรายการประเภท Action ที่มีอยู่ในระบบสำหรับ Dropdown
        $actions = [
            'LOGIN_SUCCESS' => 'LOGIN_SUCCESS (เข้าสู่ระบบสำเร็จ)',
            'LOGIN_FAIL'    => 'LOGIN_FAIL (เข้าสู่ระบบล้มเหลว)',
            'LOGOUT'        => 'LOGOUT (ออกจากระบบ)',
            'CREATE'        => 'CREATE (สร้างข้อมูลใหม่)',
            'UPDATE'        => 'UPDATE (แก้ไขข้อมูล)',
            'DELETE'        => 'DELETE (ลบข้อมูล)',
            'TOGGLE'        => 'TOGGLE (สลับสถานะ)',
        ];

        // ดึงรายชื่อตารางเฉพาะ Prefix spm_seed_ สำหรับ Dropdown
        $tables = DB::table('ACC_Center.dbo.audit_log')
            ->select('table_name')
            ->where('table_name', 'LIKE', AuditLogService::PREFIX . '%')
            ->distinct()
            ->orderBy('table_name')
            ->pluck('table_name');

        return view('AuditLog.index', compact('actions', 'tables'));
    }

    /**
     * ดึงข้อมูลรายการ Log และคำนวณสถิติแบบ Real-time (AJAX)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getData(Request $request): JsonResponse
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $action = $request->input('action');
            $tableName = $request->input('table_name');
            $keyword = trim((string)$request->input('keyword'));

            // Query พื้นฐาน กรองเฉพาะ Prefix ของระบบนี้
            $query = DB::table('ACC_Center.dbo.audit_log as a')
                ->leftJoin('Vperson as p', 'p.idPs', '=', 'a.user_id')
                ->leftJoin('dCompany as c', 'c.idComp', '=', 'a.branch_id')
                ->where('a.table_name', 'LIKE', AuditLogService::PREFIX . '%')
                ->select([
                    'a.id',
                    'a.user_id',
                    'a.username',
                    'a.user_role',
                    'a.branch_id',
                    'a.action',
                    'a.table_name',
                    'a.record_id',
                    'a.old_values',
                    'a.new_values',
                    'a.description',
                    'a.ip_address',
                    'a.user_agent',
                    'a.created_at',
                    'p.fullname as emp_fullname',
                    'p.PsNickName as emp_nickname',
                    'p.DeptName as emp_dept',
                    'c.CompCode_ as comp_code',
                    'c.CompName as comp_name',
                ]);

            // กรองตามวันที่เริ่มต้น
            if (!empty($startDate)) {
                $startDateTime = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTimeString();
                $query->where('a.created_at', '>=', $startDateTime);
            }

            // กรองตามวันที่สิ้นสุด
            if (!empty($endDate)) {
                $endDateTime = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTimeString();
                $query->where('a.created_at', '<=', $endDateTime);
            }

            // กรองตามประเภท Action
            if (!empty($action) && $action !== 'all') {
                $query->where('a.action', $action);
            }

            // กรองตามชื่อตาราง
            if (!empty($tableName) && $tableName !== 'all') {
                $query->where('a.table_name', $tableName);
            }

            // กรองตามคำค้นหา (ชื่อ / IP / รายละเอียด / Record ID / User ID)
            if (!empty($keyword)) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('a.description', 'LIKE', "%{$keyword}%")
                      ->orWhere('a.ip_address', 'LIKE', "%{$keyword}%")
                      ->orWhere('a.username', 'LIKE', "%{$keyword}%")
                      ->orWhere('p.fullname', 'LIKE', "%{$keyword}%")
                      ->orWhere('p.PsNickName', 'LIKE', "%{$keyword}%")
                      ->orWhere('a.table_name', 'LIKE', "%{$keyword}%");

                    if (is_numeric($keyword)) {
                        $q->orWhere('a.record_id', (int)$keyword)
                          ->orWhere('a.user_id', (int)$keyword);
                    }
                });
            }

            // ดึงข้อมูล 1,000 รายการล่าสุด
            $logs = $query->orderBy('a.created_at', 'DESC')
                          ->orderBy('a.id', 'DESC')
                          ->limit(1000)
                          ->get();

            // คำนวณสรุปสถิติ (Summary Cards)
            $statsQuery = DB::table('ACC_Center.dbo.audit_log as a')
                ->where('a.table_name', 'LIKE', AuditLogService::PREFIX . '%');

            if (!empty($startDate)) {
                $startDateTime = Carbon::createFromFormat('Y-m-d', $startDate)->startOfDay()->toDateTimeString();
                $statsQuery->where('a.created_at', '>=', $startDateTime);
            }
            if (!empty($endDate)) {
                $endDateTime = Carbon::createFromFormat('Y-m-d', $endDate)->endOfDay()->toDateTimeString();
                $statsQuery->where('a.created_at', '<=', $endDateTime);
            }

            $stats = [
                'total'         => (clone $statsQuery)->count(),
                'login_success' => (clone $statsQuery)->where('action', 'LOGIN_SUCCESS')->count(),
                'login_fail'    => (clone $statsQuery)->where('action', 'LOGIN_FAIL')->count(),
                'crud_count'    => (clone $statsQuery)->whereIn('action', ['CREATE', 'UPDATE', 'DELETE', 'TOGGLE'])->count(),
            ];

            // แปลงรูปแบบข้อมูลเพื่อแสดงผลในตาราง
            $formattedLogs = $logs->map(function ($item, $index) {
                // จัดการรูปแบบวันที่และเวลาแบบไทย (พ.ศ.)
                $createdAtObj = Carbon::parse($item->created_at);
                $thaiYear = $createdAtObj->year + 543;
                $thaiMonths = [
                    1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
                    5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
                    9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
                ];
                $formattedDateTime = $createdAtObj->day . ' ' . $thaiMonths[$createdAtObj->month] . ' ' . $thaiYear . ' ' . $createdAtObj->format('H:i:s');

                // จัดการชื่อผู้ใช้งาน
                $userDisplayName = $item->emp_fullname ?? $item->username ?? '-';
                if (!empty($item->emp_nickname)) {
                    $userDisplayName .= " [{$item->emp_nickname}]";
                }

                return [
                    'id'            => $item->id,
                    'seq'           => $index + 1,
                    'created_at'    => $formattedDateTime,
                    'user_id'       => $item->user_id,
                    'user_name'     => $userDisplayName,
                    'branch_id'     => $item->branch_id,
                    'branch_code'   => $item->comp_code ?? ($item->branch_id ? (string)$item->branch_id : '-'),
                    'action'        => $item->action,
                    'table_name'    => $item->table_name,
                    'record_id'     => $item->record_id ?? '-',
                    'description'   => $item->description ?? '-',
                    'ip_address'    => $item->ip_address ?? '-',
                    'user_agent'    => $item->user_agent ?? '-',
                    'has_old'       => !empty($item->old_values),
                    'has_new'       => !empty($item->new_values),
                    'old_values'    => $item->old_values,
                    'new_values'    => $item->new_values,
                ];
            });

            return response()->json([
                'success' => true,
                'stats'   => $stats,
                'data'    => $formattedLogs,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการโหลดข้อมูล Audit Log: ' . $e->getMessage(),
                'stats'   => [
                    'total'         => 0,
                    'login_success' => 0,
                    'login_fail'    => 0,
                    'crud_count'    => 0,
                ],
                'data'    => [],
            ], 500);
        }
    }

    /**
     * ดึงรายละเอียดของรายการ Audit Log เพื่อแสดงใน Modal (AJAX)
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getDetail(int $id): JsonResponse
    {
        try {
            $log = DB::table('ACC_Center.dbo.audit_log as a')
                ->leftJoin('Vperson as p', 'p.idPs', '=', 'a.user_id')
                ->leftJoin('dCompany as c', 'c.idComp', '=', 'a.branch_id')
                ->where('a.id', $id)
                ->where('a.table_name', 'LIKE', AuditLogService::PREFIX . '%')
                ->select([
                    'a.*',
                    'p.fullname as emp_fullname',
                    'p.PsNickName as emp_nickname',
                    'p.DeptName as emp_dept',
                    'c.CompCode_ as comp_code',
                    'c.CompName as comp_name',
                ])
                ->first();

            if (!$log) {
                return response()->json([
                    'success' => false,
                    'message' => 'ไม่พบข้อมูล Audit Log ที่ต้องการ',
                ], 404);
            }

            // จัดรูปแบบวันที่แบบไทย
            $createdAtObj = Carbon::parse($log->created_at);
            $thaiYear = $createdAtObj->year + 543;
            $thaiDate = $createdAtObj->day . '/' . str_pad($createdAtObj->month, 2, '0', STR_PAD_LEFT) . '/' . $thaiYear . ' ' . $createdAtObj->format('H:i:s');

            return response()->json([
                'success' => true,
                'data'    => [
                    'id'          => $log->id,
                    'action'      => $log->action,
                    'table_name'  => $log->table_name,
                    'record_id'   => $log->record_id,
                    'description' => $log->description,
                    'user_id'     => $log->user_id,
                    'username'    => $log->emp_fullname ?? $log->username ?? '-',
                    'nickname'    => $log->emp_nickname,
                    'dept'        => $log->emp_dept,
                    'branch_id'   => $log->branch_id,
                    'branch_name' => $log->comp_name ?? $log->comp_code,
                    'ip_address'  => $log->ip_address,
                    'user_agent'  => $log->user_agent,
                    'created_at'  => $thaiDate,
                    'old_values'  => $log->old_values ? json_decode($log->old_values, true) : null,
                    'new_values'  => $log->new_values ? json_decode($log->new_values, true) : null,
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาดในการโหลดรายละเอียด: ' . $e->getMessage(),
            ], 500);
        }
    }
}
