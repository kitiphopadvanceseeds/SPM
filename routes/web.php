<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QrCodeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login'); //ค่อยมาแก้
});

// Central SSO Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'redirectToSso'])->name('login');
Route::get('/sso/callback', [App\Http\Controllers\Auth\LoginController::class, 'ssoCallback'])->name('sso.callback');
Route::match(['get', 'post'], '/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/Seed/qr/{id}', [QrCodeController::class, 'showQr'])->name('seed.qr');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'home', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
});
Route::group(['prefix' => 'selectComp', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'selectComp']);
});
Route::group(['prefix' => 'SelectSeason', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'SelectSeason']);
});



Route::get('/Seed/getGrade', [App\Http\Controllers\GetSdFrController::class, 'getGrade']);
// Route Group มี prefix 'Seed'   // เพิ่มเติมถถ้าใช้อันนี้จะต้งlogin เสมอ ถ้าgetธรรมต้องเอาออกมาไว้ข้างนอก
Route::group(['prefix' => 'Seed', 'middleware' => ['auth']], function () {
    Route::get('/DB_GetSd', [App\Http\Controllers\GetSdFrController::class, 'DB_GetSd']);
    Route::get('/getFarmer', [App\Http\Controllers\GetSdFrController::class, 'getFarmer']); //ไว้ใช้ร่วมกันกับอีกคอนโทลเลอร์อื่น
    Route::get('/DB_GetSeedsByJob', [App\Http\Controllers\GetSdFrController::class, 'DB_GetSeedsByJob']);
    Route::get('/Get_RefNum', [App\Http\Controllers\GetSdFrController::class, 'Get_RefNum']);
    // Route::get('/getGrade', [App\Http\Controllers\GetSdFrController::class, 'getGrade']);
    Route::post('/SaveData', [App\Http\Controllers\GetSdFrController::class, 'SaveData']);
    Route::post('/UpdateDBNote', [App\Http\Controllers\GetSdFrController::class, 'UpdateDBNote']);
    Route::post('/SelectSeason', [App\Http\Controllers\GetSdFrController::class, 'SelectSeason']);
    Route::get('/SeedDetail/{id}', [App\Http\Controllers\GetSdFrController::class, 'SeedDetail']);
    // Route::get('/showQr', [App\Http\Controllers\GetSdFrController::class, 'showQr']);
    Route::get('/Show_Detail', [App\Http\Controllers\GetSdFrController::class, 'Show_Detail']);

});


// Route::get('/GetSdFr/getGrade', [App\Http\Controllers\GetSdFrController::class, 'getGrade']);
// // Route Group มี prefix 'GetSdFr'   // เพิ่มเติมถถ้าใช้อันนี้จะต้งlogin เสมอ ถ้าgetธรรมต้องเอาออกมาไว้ข้างนอก
// Route::group(['prefix' => 'GetSdFr', 'middleware' => ['auth']], function () {
//     Route::get('/DB_GetSdFr', [App\Http\Controllers\GetSdFrController::class, 'DB_GetSdFr']);
//     Route::get('/getFarmer', [App\Http\Controllers\GetSdFrController::class, 'getFarmer']); //ไว้ใช้ร่วมกันกับอีกคอนโทลเลอร์อื่น
//     Route::get('/DB_GetSeedsByJob', [App\Http\Controllers\GetSdFrController::class, 'DB_GetSeedsByJob']);
//     Route::get('/Get_RefNum', [App\Http\Controllers\GetSdFrController::class, 'Get_RefNum']);
//     // Route::get('/getGrade', [App\Http\Controllers\GetSdFrController::class, 'getGrade']);
//     Route::post('/SaveData', [App\Http\Controllers\GetSdFrController::class, 'SaveData']);
//     Route::post('/UpdateDBNote', [App\Http\Controllers\GetSdFrController::class, 'UpdateDBNote']);
//     Route::post('/SelectSeason', [App\Http\Controllers\GetSdFrController::class, 'SelectSeason']);
// });

// URL ที่ถูกต้องจะเป็น: /GetSdFr/DB_GetSdFr

Route::group(['prefix' => 'Seed', 'middleware' => ['auth']], function () {
    Route::get('/{type}', [App\Http\Controllers\GetSdFrController::class, 'GetSdFr']);
    // Route::get('/', [App\Http\Controllers\GetSdFrController::class, 'GetSdFr']);
    // Route::get('/getFarmer', [App\Http\Controllers\GetSdFrController::class, 'getFarmer']); //ไว้ใช้ร่วมกันกับอีกคอนโทลเลอร์อื่น
    // Route::get('/DB_GetSdFr', [App\Http\Controllers\GetSdFrController::class, 'DB_GetSdFr']);

    //ไว้ทดสอบ
    Route::get('/test-seeds', [App\Http\Controllers\GetSdFrController::class, 'index2']); //ไว้ใช้ร่วมกันกับอีกคอนโทลเลอร์อื่น
    Route::get('/test-seeds-data', [App\Http\Controllers\GetSdFrController::class, 'getData']); //ไว้ใช้ร่วมกันกับอีกคอนโทลเลอร์อื่น
});

Route::group(['prefix' => 'comp', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'comp']);
    Route::get('/CompeName', [App\Http\Controllers\HomeController::class, 'CompeName']);
    Route::get('/get_emp', [App\Http\Controllers\HomeController::class, 'get_emp']);
});

Route::group(['prefix' => 'audit-log', 'middleware' => ['auth']], function () {
    Route::get('/', [App\Http\Controllers\AuditLogController::class, 'index'])->name('audit.log');
    Route::get('/data', [App\Http\Controllers\AuditLogController::class, 'getData'])->name('audit.log.data');
    Route::get('/detail/{id}', [App\Http\Controllers\AuditLogController::class, 'getDetail'])->name('audit.log.detail');
});



Route::get('/image-proxy/{id}', function($id) {
    $url = "http://203.151.27.229/spm/images/pPs/$id.jpg";
    $image = @file_get_contents($url);

    if (!$image) {
        abort(404);
    }

    return response($image)->header('Content-Type', 'image/jpeg');
});

