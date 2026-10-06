<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service Class สำหรับเชื่อมต่อกับระบบ Central SSO (Advance Seeds Single Sign-On)
 * 
 * ฟังก์ชันหลัก:
 * - สร้าง URL สำหรับ Redirect ไปหน้า Login กลาง (getAuthorizeUrl)
 * - แลกเปลี่ยน One-time Ticket เป็น User Token & Profile (exchangeTicket)
 * - สร้าง URL สำหรับออกจากระบบกลาง (getLogoutUrl)
 */
class CentralAuthClient
{
    /**
     * ดึง Base URL ของเซิร์ฟเวอร์ระบบยืนยันตัวตนกลาง
     *
     * @return string
     */
    public static function getBaseUrl(): string
    {
        return rtrim((string) config('services.central_auth.url', env('CENTRAL_AUTH_URL', 'https://auth.advanceseeds.com')), '/');
    }

    /**
     * ดึง App Code ประจำโปรเจกต์
     *
     * @return string
     */
    public static function getAppCode(): string
    {
        return (string) config('services.central_auth.app', env('CENTRAL_AUTH_APP', 'spmseed-app'));
    }

    /**
     * ดึง App Secret ประจำโปรเจกต์
     *
     * @return string
     */
    public static function getAppSecret(): string
    {
        return (string) config('services.central_auth.secret', env('CENTRAL_AUTH_SECRET', 'fb8bae91181e912a7b504886e411b178575e7da2382ce8a3'));
    }

    /**
     * สร้าง URL สำหรับ Redirect ไปหน้า Login กลาง
     *
     * @param string|null $returnUrl URL ที่ต้องการให้ SSO ส่งกลับมาหลังเข้าสู่ระบบสำเร็จ
     * @return string
     */
    public static function getAuthorizeUrl(?string $returnUrl = null): string
    {
        if (empty($returnUrl)) {
            $returnUrl = url('/sso/callback');
        }

        // บังคับ HTTPS เฉพาะบน Production (ไม่บังคับบน localhost / 127.0.0.1)
        $isLocalhost = str_contains($returnUrl, 'localhost') || str_contains($returnUrl, '127.0.0.1');
        if (!$isLocalhost && (app()->environment('production') || str_starts_with((string) config('app.url', ''), 'https://'))) {
            $returnUrl = (string) preg_replace('/^http:\/\//i', 'https://', $returnUrl);
        }

        $baseUrl = self::getBaseUrl();
        $app = self::getAppCode();

        return "{$baseUrl}/sso/authorize?app=" . urlencode($app) . "&return=" . urlencode($returnUrl);
    }

    /**
     * แลกเปลี่ยน One-Time Ticket เป็น Token และข้อมูลพนักงานจากเซิร์ฟเวอร์กลาง
     *
     * @param string $ticket รหัส Ticket ที่ได้รับจาก Callback
     * @return array{success: bool, data: array|null, error: string|null}
     */
    public static function exchangeTicket(string $ticket): array
    {
        try {
            $baseUrl = self::getBaseUrl();
            $app     = self::getAppCode();
            $secret  = self::getAppSecret();

            $payload = [
                'ticket'     => $ticket,
                'app'        => $app,
                'app_code'   => $app,
                'app_secret' => $secret,
                'secret'     => $secret,
            ];

            $response = Http::timeout(15)
                ->withoutVerifying()
                ->withHeaders([
                    'X-App-Code'   => $app,
                    'X-App-Secret' => $secret,
                ])
                ->asJson()
                ->acceptJson()
                ->post("{$baseUrl}/sso/exchange", $payload);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['success']) && $data['success'] === true) {
                    return [
                        'success' => true,
                        'data'    => $data['data'] ?? [],
                        'error'   => null,
                    ];
                }

                return [
                    'success' => false,
                    'data'    => null,
                    'error'   => $data['error'] ?? $data['message'] ?? 'การยืนยันตัวตนล้มเหลว',
                ];
            }

            $errBody = $response->json();
            $errorMsg = $errBody['error'] ?? $errBody['message'] ?? 'เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์กลาง (HTTP ' . $response->status() . ')';

            Log::error('CentralAuth SSO Exchange Failed: ' . $errorMsg, [
                'status' => $response->status(),
                'body'   => $errBody,
            ]);

            return [
                'success' => false,
                'data'    => null,
                'error'   => $errorMsg,
            ];
        } catch (\Throwable $e) {
            Log::error('CentralAuth SSO Exception: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            return [
                'success' => false,
                'data'    => null,
                'error'   => 'ไม่สามารถติดต่อเซิร์ฟเวอร์ระบบยืนยันตัวตนกลางได้: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * สร้าง URL สำหรับออกจากระบบกลาง (Global Logout)
     *
     * @param string|null $returnUrl URL ที่จะพาผู้ใช้กลับมาหลังออกจากระบบ
     * @param bool $all ออกจากระบบทุกโปรแกรมในเครือพร้อมกันหรือไม่
     * @return string
     */
    public static function getLogoutUrl(?string $returnUrl = null, bool $all = false): string
    {
        if (empty($returnUrl)) {
            $returnUrl = url('/login');
        }

        $isLocalhost = str_contains($returnUrl, 'localhost') || str_contains($returnUrl, '127.0.0.1');
        if (!$isLocalhost && (app()->environment('production') || str_starts_with((string) config('app.url', ''), 'https://'))) {
            $returnUrl = (string) preg_replace('/^http:\/\//i', 'https://', $returnUrl);
        }

        $baseUrl = self::getBaseUrl();
        $app = self::getAppCode();

        $url = "{$baseUrl}/sso/logout?app=" . urlencode($app) . "&return=" . urlencode($returnUrl);
        if ($all) {
            $url .= '&all=1';
        }

        return $url;
    }
}
