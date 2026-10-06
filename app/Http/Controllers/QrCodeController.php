<?php
namespace App\Http\Controllers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeController extends Controller
{
    public function showQr($id)
    {
        $url = url("/Seed/SeedDetail/{$id}");
        
        // ใช้ new Builder() แทน Builder::create()
        $result = (new Builder())
            ->writer(new PngWriter())
            ->data($url)
            ->size(200)
            ->margin(10)
            ->build();
        
        // แปลงเป็น Data URI
        $qrCodeString = $result->getDataUri();
        
        return view('Seeds.qr_test', compact('qrCodeString', 'url', 'id'));
    }
}