<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

/**
 * Service สำหรับจัดการบันทึกและดึงข้อมูล Audit Log
 * เชื่อมต่อกับตาราง [ACC_Center].[dbo].[audit_log]
 * 
 * ใช้ Prefix: spm_seed_ สำหรับระบบ SPM คลังเมล็ด
 */
class AuditLogService
{
    /**
     * กำหนด Prefix สำหรับระบบ SPM คลังเมล็ด
     */
    public const PREFIX = 'spm_seed_';

    /**
     * บันทึกกิจกรรมลงในตาราง [ACC_Center].[dbo].[audit_log]
     *
     * @param string $action ประเภทกิจกรรม (CREATE, UPDATE, DELETE, LOGIN_SUCCESS, LOGIN_FAIL, LOGOUT, toggle)
     * @param string $tableName ชื่อตารางที่มี prefix spm_seed_ (เช่น spm_seed_login, spm_seed_job_rec)
     * @param int|string|null $recordId ไอดีของรายการที่ทำ
     * @param mixed $oldValues ข้อมูลก่อนหน้า (Array, Object หรือ JSON string)
     * @param mixed $newValues ข้อมูลใหม่ (Array, Object หรือ JSON string)
     * @param string|null $description คำอธิบายกิจกรรม
     * @param int|null $userId รหัสพนักงาน (ถ้าไม่ระบุจะดึงจาก Auth)
     * @param int|null $branchId รหัสสาขา/บริษัท (ถ้าไม่ระบุจะดึงจาก session)
     * @return bool สถานะการบันทึก (true = สำเร็จ, false = ล้มเหลว)
     */
    public static function log(
        string $action,
        string $tableName,
        $recordId = null,
        $oldValues = null,
        $newValues = null,
        ?string $description = null,
        ?int $userId = null,
        ?int $branchId = null
    ): bool {
        try {
            // ดึงข้อมูล User จากระบบ Authentication
            $currentUser = Auth::user();
            $finalUserId = $userId ?? ($currentUser ? ($currentUser->idPs ?? $currentUser->id ?? null) : session('idPs'));
            $username = $currentUser ? ($currentUser->UN ?? $currentUser->fullname ?? $currentUser->PsName ?? null) : session('name');
            $userRole = session('user_role') ?? 'staff';

            // ดึงข้อมูลสาขา/บริษัทจาก Session
            $finalBranchId = $branchId ?? session('idComp');

            // จัดการ Format ข้อมูล JSON สำหรับ old_values และ new_values
            $oldJson = self::formatJson($oldValues);
            $newJson = self::formatJson($newValues);

            // ดึง IP Address และ User Agent
            $ipAddress = Request::ip() ?? '127.0.0.1';
            $userAgent = substr(Request::userAgent() ?? 'Unknown', 0, 300);

            // ตรวจสอบความถูกต้องของ record_id ให้เป็นตัวเลข int หากเป็นไปได้
            $cleanRecordId = is_numeric($recordId) ? (int)$recordId : null;

            // ตรวจสอบความยาว Description ไม่ให้เกิน 500 ตัวอักษร
            $cleanDescription = $description ? mb_substr($description, 0, 500, 'UTF-8') : null;

            // บันทึกลงตาราง [ACC_Center].[dbo].[audit_log]
            DB::table('ACC_Center.dbo.audit_log')->insert([
                'user_id'     => $finalUserId,
                'username'    => $username ? substr($username, 0, 50) : null,
                'user_role'   => $userRole ? substr($userRole, 0, 20) : null,
                'branch_id'   => $finalBranchId,
                'action'      => substr($action, 0, 30),
                'table_name'  => substr($tableName, 0, 50),
                'record_id'   => $cleanRecordId,
                'old_values'  => $oldJson,
                'new_values'  => $newJson,
                'description' => $cleanDescription,
                'ip_address'  => substr($ipAddress, 0, 45),
                'user_agent'  => $userAgent,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            return true;
        } catch (\Throwable $e) {
            // บันทึก Log ข้อผิดพลาดลง Laravel Log เพื่อไม่ให้กระทบ Business Logic หลัก
            Log::error('AuditLogService Error: ' . $e->getMessage(), [
                'action'     => $action,
                'table_name' => $tableName,
                'record_id'  => $recordId,
            ]);
            return false;
        }
    }

    /**
     * แปลงข้อมูลให้อยู่ในรูปแบบ JSON String
     *
     * @param mixed $data
     * @return string|null
     */
    protected static function formatJson($data): ?string
    {
        if ($data === null) {
            return null;
        }

        if (is_string($data)) {
            // ตรวจสอบว่าข้อความเป็น JSON อยู่แล้วหรือไม่
            json_decode($data);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            }
            return json_encode(['text' => $data], JSON_UNESCAPED_UNICODE);
        }

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}
