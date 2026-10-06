<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\dEmployee;
use App\Providers\RouteServiceProvider;
use App\Services\AuditLogService;
use App\Services\CentralAuthClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller สำหรับจัดการระบบยืนยันตัวตนผ่าน Central SSO (Advance Seeds)
 * 
 * ฟังก์ชันหลัก:
 * - Redirect ผู้ใช้ไปล็อกอินที่หน้าจอกลาง (redirectToSso)
 * - รับ Callback และแลกเปลี่ยน Ticket (ssoCallback)
 * - บันทึก Audit Log (LOGIN_SUCCESS, LOGIN_FAIL, LOGOUT)
 * - รองรับการ Logout แบบ Local และ Global SSO
 */
class LoginController extends Controller
{
    /**
     * กำหนด Middleware สำหรับ Controller
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect ผู้ใช้งานไปยังหน้าจอเข้าสู่ระบบของ Central SSO
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function redirectToSso(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        $callbackUrl = route('sso.callback');
        $authorizeUrl = CentralAuthClient::getAuthorizeUrl($callbackUrl);

        return redirect()->away($authorizeUrl);
    }

    /**
     * แสดงหน้าฟอร์ม Login (Redirect ไป SSO)
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function showLoginForm(Request $request): RedirectResponse
    {
        return $this->redirectToSso($request);
    }

    /**
     * รับ Callback หลังผู้ใช้งานล็อกอินจากระบบกลางสำเร็จ
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function ssoCallback(Request $request)
    {
        $ticket = $request->query('ticket', $request->input('ticket'));

        // ตรวจสอบว่ามี Ticket ส่งกลับมาหรือไม่
        if (empty($ticket)) {
            $errorMsg = $request->query('error', 'ไม่พบรหัสยืนยันตัวตน (Ticket not found)');
            
            AuditLogService::log(
                'LOGIN_FAIL',
                'spm_seed_login',
                null,
                null,
                ['error' => $errorMsg],
                "เข้าสู่ระบบล้มเหลว: {$errorMsg}"
            );

            return view('auth.sso_error', ['message' => $errorMsg]);
        }

        // ส่ง Ticket ไปแลก Token และข้อมูลผู้ใช้กับ Server กลาง
        $exchangeResult = CentralAuthClient::exchangeTicket((string) $ticket);

        if (!$exchangeResult['success'] || empty($exchangeResult['data'])) {
            $errorMsg = $exchangeResult['error'] ?? 'การยืนยันตัวตนกับระบบกลางล้มเหลว';

            AuditLogService::log(
                'LOGIN_FAIL',
                'spm_seed_login',
                null,
                null,
                ['ticket' => $ticket, 'error' => $errorMsg],
                "เข้าสู่ระบบล้มเหลว: {$errorMsg}"
            );

            return view('auth.sso_error', ['message' => $errorMsg]);
        }

        $tokenData = $exchangeResult['data'];
        $userData  = $tokenData['user'] ?? [];
        $idPs      = $userData['idPs'] ?? null;
        $username  = $userData['UN'] ?? $userData['username'] ?? $userData['PsCode'] ?? null;

        // ค้นหาข้อมูลพนักงานในฐานข้อมูลระบบ
        $employee = null;
        if ($idPs) {
            $employee = dEmployee::where('idPs', $idPs)->first();
        }
        if (!$employee && $username) {
            $employee = dEmployee::where('UN', $username)->first();
        }

        // กรณีไม่พบข้อมูลพนักงานในฐานข้อมูล
        if (!$employee) {
            $errorMsg = "ไม่พบข้อมูลพนักงานในระบบ (ID: {$idPs}, Username: {$username}) กรุณาติดต่อผู้ดูแลระบบ";

            AuditLogService::log(
                'LOGIN_FAIL',
                'spm_seed_login',
                null,
                null,
                ['user_payload' => $userData],
                $errorMsg
            );

            return view('auth.sso_error', ['message' => $errorMsg]);
        }

        // สั่ง Login เข้าระบบ Laravel Auth
        Auth::login($employee);
        $request->session()->regenerate();

        $displayName = $userData['PsName'] ?? $employee->fullname;

        // เซ็ตตัวแปร Session ที่ระบบต้องการใช้งาน
        session([
            'idPs'                       => $employee->idPs,
            'name'                       => $displayName,
            'fullname'                   => $displayName,
            'User'                       => $employee->UN,
            'UN'                         => $employee->UN,
            'user_role'                  => $userData['Role'] ?? $userData['role'] ?? 'staff',
            'depName'                    => $userData['DeptName'] ?? 'User',
            'central_auth_access_token'  => $tokenData['access_token'] ?? null,
            'central_auth_refresh_token' => $tokenData['refresh_token'] ?? null,
            'central_auth_expires_at'    => now()->addSeconds($tokenData['expires_in'] ?? 3600)->timestamp,
            'central_auth_payload'       => $userData,
        ]);

        // บันทึกประวัติการเข้าสู่ระบบลง Audit Log
        AuditLogService::log(
            'LOGIN_SUCCESS',
            'spm_seed_login',
            $employee->idPs,
            null,
            null,
            "เข้าสู่ระบบสำเร็จ (SSO): {$displayName}",
            $employee->idPs,
            session('idComp')
        );

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * ออกจากระบบ (รองรับทั้ง Local Logout และ Global SSO Logout)
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $type = $request->input('type', $request->query('type', 'local'));
        $currentUserId = Auth::id() ?? session('idPs');
        $currentName = session('name') ?? (Auth::user()?->fullname ?? 'User');
        $branchId = session('idComp');

        // บันทึก Log การออกจากระบบ
        AuditLogService::log(
            'LOGOUT',
            'spm_seed_login',
            $currentUserId,
            null,
            null,
            $type === 'global' ? "ออกจากระบบกลางทั้งหมด (Global SSO): {$currentName}" : "ออกจากระบบเฉพาะแอป (Local Logout): {$currentName}",
            $currentUserId,
            $branchId
        );

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($type === 'global') {
            $globalLogoutUrl = CentralAuthClient::getLogoutUrl(route('login'), true);
            return redirect()->away($globalLogoutUrl);
        }

        return redirect()->route('login');
    }
}
