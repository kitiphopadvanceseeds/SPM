<?php

namespace App\Http\Controllers;

use App\Models\PdIndexJobDt;
use App\Models\PdIndexJobRec;
use App\Models\PdIndexJobRecPack;


use App\Models\test_PdIndexJobRec22;
use Hamcrest\Core\IsNot;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use App\Services\AuditLogService;

class GetSdFrController extends Controller
{

    public function GetSdFr($type)
    // public function GetSdFr()
    {
        
        $data['type'] = $type; 
        $data['Season'] = DB::SELECT("SELECT * FROM dSeasonOfProduce");

        return view('Seeds.Seeds', $data);
    }

    public function DB_GetSd(Request $request )
    {
        // return response()->json($request->all());
        // $idFarmer = $request->input('idFarmer1');
        // $IDFm = '';
        // if ($idFarmer != null) {
        //     $IDFm = "AND idFm = $idFarmer";
        // } else {
        //     $IDFm = '';
        // }

        // $idSeason = $request->input('idSeason');
        // $IDS = '';
        // if ($idSeason != null) {
        //     $IDS = "AND idSeasonPd = $idSeason ";
        // } else {
        //     $IDS = '';
        // }

        $idFarmer = $request->input('idFarmer1');
        $IDFm = '';
        if ($idFarmer != null) {
            $IDFm = "AND idFm = $idFarmer";
        }
       
        $idSeason = $request->input('idSeason');
        $IDS = '';
        if ($idSeason != null) {
            $IDS = "AND idSeasonPd = $idSeason ";
        }

        $idSeason2 = session()->get('Season');

        $now = Carbon::now();
        // วันที่ พ.ศ. (dd/mm/พ.ศ.)
        // $thaiDate = $now->format('d/m/') . ($now->year + 543);
        // รูปแบบ YYYYMMDD (พ.ศ.)
        $thaiDateNumber = ($now->year + 543) . $now->format('md');
        // dd($thaiDateNumber);

        // $type = $request->query('type', 'main');
        $type = $request->query('type', default: 'farmer');
        // $type = $request->query('type');

        // if ($idFarmer == null && $idSeason == null) {
        //     $data1['GetSdFr'] = DB::select("SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb,PsName  
        //                                         FROM vPdIndexJobDtRec  
        //                                         WHERE  idSeasonPd = $idSeason2  AND idJobLine <> '9' AND ((DateReceive_ <= '$thaiDateNumber') OR (DateHarvest_ <= '$thaiDateNumber' AND  DateReceive_ > '$thaiDateNumber'))  
        //                                         AND  idComp = " . session()->get('idComp') . " 
        //                                         ORDER BY DateReceive_ ");
        // } else {
        //     $data1['GetSdFr'] = DB::select("SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb,PsName   
        //                                     FROM vPdIndexJobDtRec  
        //                                     WHERE idJobLine <> '9' AND ((DateReceive_ <= '$thaiDateNumber') OR (DateHarvest_ <= '$thaiDateNumber' AND  DateReceive_ > '$thaiDateNumber'))  
        //                                     AND  idComp = " . session()->get('idComp') . " $IDFm $IDS
        //                                     ORDER BY DateReceive_ ");
        // }

        // if ($idFarmer == null && $idSeason == null) {
        //     $data2['GetSdFr'] = DB::select("SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb,PsName 
        //                                 FROM vPdIndexJobDtRec  
        //                                 WHERE idSeasonPd = $idSeason2 And idJobLine <> '9'   And ((DateReceive_ > '$thaiDateNumber') OR (DateHarvest_ > '$thaiDateNumber' And  DateReceive_ < '$thaiDateNumber')) 
        //                                 AND idComp = " . session()->get('idComp') . "
        //                                 ORDER BY DateMete ");
        // } else {
        //     $data2['GetSdFr'] = DB::select("SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb ,PsName 
        //                                     FROM vPdIndexJobDtRec  
        //                                     WHERE idJobLine <> '9' AND ((DateReceive_ <= '$thaiDateNumber') OR (DateHarvest_ <= '$thaiDateNumber' AND  DateReceive_ > '$thaiDateNumber'))  
        //                                     AND  idComp = " . session()->get('idComp') . " $IDFm $IDS
        //                                     ORDER BY DateReceive_ ");
        // }

        if ($idFarmer == null && $idSeason == null) {
            $data1['GetSdFr'] = DB::select("SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb,PsName  ,SeasonCode
                                                FROM vPdIndexJobDtRec  
                                                WHERE  idSeasonPd = $idSeason2   AND ISNULL(idJobLine,0) NOT IN ('0','10','9') --AND idJobLine <> '9' 
                                                AND ((DateReceive_ <= ?) OR (DateHarvest_ <= ? AND  DateReceive_ > ?))  AND vPdIndexJobDtRec.idJob NOT IN (SELECT idJob FROM vPdIndexJobRecPack WHERE vPdIndexJobRecPack.idJob=vPdIndexJobDtRec.idJob AND vPdIndexJobRecPack.stCancel IS NULL)
                                                AND  idComp = " . session()->get('idComp') . " 
                                                ORDER BY DateReceive_ " ,[$thaiDateNumber, $thaiDateNumber, $thaiDateNumber]);
        } else {
            $data1['GetSdFr'] = DB::select("SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb,PsName  ,SeasonCode 
                                            FROM vPdIndexJobDtRec  
                                            WHERE ISNULL(idJobLine,0) NOT IN ('0','10','9') --idJobLine <> '9' 
                                            AND ((DateReceive_ <= ?) OR (DateHarvest_ <= ? AND  DateReceive_ > ?)) AND vPdIndexJobDtRec.idJob NOT IN (SELECT idJob FROM vPdIndexJobRecPack WHERE vPdIndexJobRecPack.idJob=vPdIndexJobDtRec.idJob AND vPdIndexJobRecPack.stCancel IS NULL) 
                                            AND  idComp = " . session()->get('idComp') . " $IDFm $IDS 
                                            ORDER BY DateReceive_ " ,[$thaiDateNumber, $thaiDateNumber, $thaiDateNumber]);
        //        // เช็คคิวรี่
        // $data1['sql'] = "SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb,PsName  ,SeasonCode 
        //     FROM vPdIndexJobDtRec  
        //     WHERE ISNULL(idJobLine,0) NOT IN ('0','10','9') --idJobLine <> '9' 
        //     AND ((DateReceive_ <= $thaiDateNumber) OR (DateHarvest_ <= $thaiDateNumber AND  DateReceive_ > $thaiDateNumber))  AND vPdIndexJobDtRec.idJob NOT IN (SELECT idJob FROM vPdIndexJobRecPack WHERE vPdIndexJobRecPack.idJob=vPdIndexJobDtRec.idJob AND vPdIndexJobRecPack.stCancel IS NULL)
        //     AND  idComp = " . session()->get('idComp') . " $IDFm $IDS 
        //     ORDER BY DateReceive_ " ;
        // // }

        }

        if ($idFarmer == null && $idSeason == null) {
            $data2['GetSdFr'] = DB::select("SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb,PsName ,SeasonCode
                                        FROM vPdIndexJobDtRec  
                                        WHERE idSeasonPd = $idSeason2 AND ISNULL(idJobLine,0) NOT IN ('0','10','9') --And idJobLine <> '9'  
                                        And ((DateReceive_ > ?) OR (DateHarvest_ > ? And  DateReceive_ < ?)) AND vPdIndexJobDtRec.idJob NOT IN (SELECT idJob FROM vPdIndexJobRecPack WHERE vPdIndexJobRecPack.idJob=vPdIndexJobDtRec.idJob AND vPdIndexJobRecPack.stCancel IS NULL)
                                        AND idComp = " . session()->get('idComp') . "
                                        ORDER BY DateMete " , [$thaiDateNumber, $thaiDateNumber, $thaiDateNumber]);
        } else {
            $data2['GetSdFr'] = DB::select("SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb ,PsName ,SeasonCode
                                            FROM vPdIndexJobDtRec  
                                            WHERE ISNULL(idJobLine,0) NOT IN ('0','10','9')--idJobLine <> '9' 
                                            AND ((DateReceive_ <= ?) OR (DateHarvest_ <= ? AND  DateReceive_ > ?))  AND vPdIndexJobDtRec.idJob NOT IN (SELECT idJob FROM vPdIndexJobRecPack WHERE vPdIndexJobRecPack.idJob=vPdIndexJobDtRec.idJob AND vPdIndexJobRecPack.stCancel IS NULL)
                                            AND  idComp = " . session()->get('idComp') . " $IDFm $IDS
                                            ORDER BY DateReceive_ " , [$thaiDateNumber, $thaiDateNumber, $thaiDateNumber]);
        }

        $data3['data_receive'] = DB::select("SELECT NumRef, FmType, idJobRecPack,
                                                SUBSTRING(REPLACE(PackCode,'-','/'), 10, 3) AS NUM, 
                                                SeasonCode, ZoneName_, PsSp,  Grade, 
                                                GR_Group.devsk.convertStrToDateThai(JrDate) AS JrDate,
                                                FmName, PlantName,  PdCode, StrainCode, PackKgRai,
                                                PackKgStore,  HumidRai, HumidStore
                                            FROM
                                                vPdIndexJobRecPack
                                            WHERE
                                                idComp = " . session()->get('idComp') . " 
                                            AND idSeasonPd = $idSeason2  $IDFm
                                            ORDER BY idjob"); 


        // if ($idFarmer == null && $idSeason == null) {
            // $data3['data_receive'] = DB::select("SELECT NumRef, FmType,
            //                                             SUBSTRING(REPLACE(PackCode,'-','/'), 10, 3) AS NUM, 
            //                                             SeasonCode, ZoneName_, PsSp,  Grade, 
            //                                             GR_Group.devsk.convertStrToDateThai(JrDate) AS JrDate,
            //                                             FmName, PlantName,  PdCode, StrainCode, PackKgRai,
            //                                             PackKgStore,  HumidRai, HumidStore
            //                                         FROM
            //                                             vPdIndexJobRecPack
            //                                         WHERE
            //                                             idComp = " . session()->get('idComp') . "
            //                                         AND idSeasonPd = $idSeason2 
            //                                         ORDER BY idjob");

        // } else {
        //     $data3['data_receive'] = DB::select("SELECT NumRef, FmType,
        //                                                 SUBSTRING(REPLACE(PackCode,'-','/'), 10, 3) AS NUM, 
        //                                                 SeasonCode, ZoneName_, PsSp,  Grade, 
        //                                                 GR_Group.devsk.convertStrToDateThai(JrDate) AS JrDate,
        //                                                 FmName, PlantName,  PdCode, StrainCode, PackKgRai,
        //                                                 PackKgStore,  HumidRai, HumidStore
        //                                             FROM
        //                                                 vPdIndexJobRecPack
        //                                             WHERE
        //                                                 idComp = " . session()->get('idComp') . "
        //                                             AND idSeasonPd = $idSeason2 
        //                                             ORDER BY idjob");
        // }

            //อันเก่าที่ลองใส่เวลาไปด้วย
            //   $data3['data_receive'] = DB::select("SELECT NumRef, FmType,
            //                                             SUBSTRING(REPLACE(PackCode,'-','/'), 10, 3) AS NUM, 
            //                                             SeasonCode, ZoneName_, PsSp,  Grade, 
            //                                             GR_Group.devsk.convertStrToDateThai(JrDate) AS JrDate,
            //                                             FmName, PlantName,  PdCode, StrainCode, PackKgRai,
            //                                             PackKgStore,  HumidRai, HumidStore
            //                                         FROM
            //                                             vPdIndexJobRecPack
            //                                         WHERE
            //                                             idComp = " . session()->get('idComp') . "
            //                                         AND idSeasonPd = $idSeason2 --AND JrDate like '%$thaiDateNumber%'
            //                                         ORDER BY idjob");



            // $data3['GetSdFr'] = DB::select("SELECT NumRef, FmType,
            //                                             SUBSTRING(REPLACE(PackCode,'-','/'), 10, 3) AS NUM, 
            //                                             SeasonCode, ZoneName_, PsSp,  Grade, 
            //                                             GR_Group.devsk.convertStrToDateThai(JrDate) AS JrDate,
            //                                             FmName PlantName,  PdCode, StrainCode, PackKgRai,
            //                                             PackKgStore,  HumidRai, HumidStore
            //                                         FROM
            //                                             vPdIndexJobRecPack
            //                                         WHERE
            //                                             idComp = 3 
            //                                         AND idSeasonPd = 96 AND JrDate like '%256810%'
            //                                         ORDER BY idjob");
        // }


        // DD($data['GetSdFr']);
        // return response()->json($data1);
        return response()->json([
            // 'data' => $type == 'pre' ? $data2 : $data1 
            // 'data' => $type == 'pending' ? $data2 : $data1 
                'type' => $type, // เพิ่มบอกว่าเป็นหน้าไหน
                'data' => match($type) {
                'receive'  => $data3,
                'pending' => $data2,
                default   => $data1,
            }
        ]);
    }


    // public function DB_GetSdFr(Request $request, $type)
    // {
    //     // รับค่า $type จาก Route Parameter ถ้ามี ถ้าไม่มีให้ใช้ค่าใน query string หรือ default 'main'
    //     // $type = $type ?? $request->query('type', 'main');
    //     // รับค่า idFarmer1 จาก request
    //     $idFarmer = $request->input('idFarmer1');
    //     $IDFm = '';
    //     if ($idFarmer != null) {
    //         $IDFm = "AND idFm = $idFarmer";
    //     }

    //     $idSeason = $request->input('idSeason');
    //     $IDS = '';
    //     if ($idSeason != null) {
    //         $IDS = "AND idSeasonPd = $idSeason ";
    //     }

    //     $idSeason2 = session()->get('Season');

    //     $now = Carbon::now();
    //     $thaiDateNumber = ($now->year + 543) . $now->format('md');

    //     // Query สำหรับ type == 'main'
    //     $queryMain = "SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,
    //                      SeedTypeName as PlantName,FmName,ZoneName_,idCompb  
    //               FROM vPdIndexJobDtRec  
    //               WHERE idJobLine <> '9' 
    //                 AND ((DateReceive_ <= '$thaiDateNumber') OR (DateHarvest_ <= '$thaiDateNumber' AND DateReceive_ > '$thaiDateNumber'))  
    //                 AND idComp = " . session()->get('idComp') . " $IDFm $IDS
    //               ORDER BY DateReceive_";

    //     // Query สำหรับ type == 'pre'
    //     $queryPre = "SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,
    //                     SeedTypeName as PlantName,FmName,ZoneName_,idCompb  
    //              FROM vPdIndexJobDtRec  
    //              WHERE idJobLine <> '9' 
    //                AND ((DateReceive_ > '$thaiDateNumber') OR (DateHarvest_ > '$thaiDateNumber' AND DateReceive_ < '$thaiDateNumber'))  
    //                AND idComp = " . session()->get('idComp') . " $IDFm $IDS
    //              ORDER BY DateMete";

    //     // if ($type === 1) {
    //     //     $data['GetSdFr'] = DB::select($queryPre);
    //     // } else {
    //     //     // default 'main'
    //     //     $data['GetSdFr'] = DB::select($queryMain);
    //     // }
    //     // $type = (int) $type;  // แปลงเป็น int

    //     $type = (int) $type; 

    //     if ($type === 1) {
    //         // ถ้า type = 1 ใช้ queryPre
    //         $data['GetSdFr'] = DB::select($queryPre);
    //     } elseif ($type === 2) {
    //         // ถ้า type = 2 ใช้ queryMain
    //         $data['GetSdFr'] = DB::select($queryMain);
    //     } else {
    //         // ค่าอื่น ๆ หรือ default
    //         $data['GetSdFr'] = DB::select($queryMain);
    //     }

    //     return response()->json([
    //         'data' => $data,
    //         'type' => $type,
    //     ]);
    // }



    function DB_GetSeedsByJob(Request $request)
    {

        $idJob = $request->input('idJob');
        $SeasonCode = $request->input('SeasonCode');

        $data['GetSeedsByJob'] = collect(DB::SELECT("SELECT * FROM vPdIndexJobDtRec WHERE idJob = ?" , [$idJob]))->first();
        // $data['GetSeedsByJob'] = collect(DB::SELECT("SELECT * FROM vPdIndexJobDt WHERE idJob = $idJob"))->first();

        $data['GetNumRef'] = collect(DB::SELECT("SELECT ISNULL(MAX(NumRef), 0) AS NumRef , SeasonCode FROM vPdIndexJobRecPack WHERE SeasonCode = ? AND stCancel IS NULL GROUP BY SeasonCode" , [$SeasonCode]))->first();

        $data['JrCode'] = collect(DB::select(
            'EXEC mdCodeGetFormat @IdCompb = ?, @rCode = ? OUTPUT',
            [$request->input('idCompb'), '']
        ))->first();

        // dd($data['JrCode']);

        return response()->json($data);
    }

    public function getFarmer()
    {

        $data['getFarmer'] = DB::select("SELECT idFm,FmNameF + ' ' + FmNameS AS FullName
                                            FROM dFarmer
                                            WHERE stDel IS NULL");

        $data['getUser'] = DB::select("SELECT idPs, PsName ,DeptName, ComName FROM Vperson");

        return response()->json($data);
    }



    public function Get_RefNum(Request $request){

        // return response()->json($request->all());

        $refNum = $request->input('refNum'); // ใช้ค่า '908' เป็นค่าเริ่มต้นถ้าไม่มีการส่งค่า
        // $data['Get_RefNum'] = DB::select("SELECT COUNT (idJN) FROM PdIndexJobRec WHERE RefNum = $refNum And stCancel is Null");
        
        $result = DB::select("SELECT COUNT(idJN) as cnt FROM PdIndexJobRec WHERE RefNum = ? AND stCancel IS NULL", [$refNum]);
        $count = $result[0]->cnt ?? 0;

        if($count >= 1){
            return response()->json(['message' => 'มีข้อมูล', 'count' => $count]);
        } else {
            return response()->json(['message' => 'ไม่มีข้อมูล', 'count' => $count]);
        }
        // return response()->json($data);
    }

    public function getGrade(){
        $data['getGrade'] = DB::select("SELECT GradeCode FROM dSeedGrade WHERE stDel=1 ORDER BY idSeedGrade ");
        return response()->json($data);
    }


    public function index2()
    {
        return view('home.test');
    }

    public function getData(Request $request)
    {
        $type = $request->query('type', 'main');

        // จำลองข้อมูลชุดหลัก
        $mainData = [
            ['job_no' => 'J001', 'expect_date' => '2025-08-01', 'prod_code' => 'P1001', 'plant' => 'ข้าวโพด', 'farmer' => 'นายแดง'],
            ['job_no' => 'J002', 'expect_date' => '2025-08-05', 'prod_code' => 'P1002', 'plant' => 'ถั่วเขียว', 'farmer' => 'นางฟ้า'],
        ];

        // จำลองข้อมูลชุดก่อนสถานะ
        $preData = [
            ['job_no' => 'J010', 'expect_date' => '2025-07-20', 'prod_code' => 'P0901', 'plant' => 'ข้าวหอม', 'farmer' => 'นายเขียว'],
            ['job_no' => 'J011', 'expect_date' => '2025-07-22', 'prod_code' => 'P0902', 'plant' => 'ถั่วเหลือง', 'farmer' => 'นางน้ำ'],
            ['job_no' => 'J011', 'expect_date555' => '2025-07-25', 'prod_code' => 'P09025', 'plant' => 'ถั่วเหลือง', 'farmer' => 'นางน้ำ'],
        ];

        return response()->json([
            'data' => $type == 'pre' ? $preData : $mainData
        ]);
    }


    public function thaiDateToNumber($dateText)
    {
        $months = [
            'มกราคม' => '01',
            'กุมภาพันธ์' => '02',
            'มีนาคม' => '03',
            'เมษายน' => '04',
            'พฤษภาคม' => '05',
            'มิถุนายน' => '06',
            'กรกฎาคม' => '07',
            'สิงหาคม' => '08',
            'กันยายน' => '09',
            'ตุลาคม' => '10',
            'พฤศจิกายน' => '11',
            'ธันวาคม' => '12',
        ];

        $parts = explode(" ", trim($dateText));
        if (count($parts) !== 3) {
            return null; // กัน error ถ้าข้อมูลไม่ครบ
        }

        $day   = str_pad($parts[0], 2, "0", STR_PAD_LEFT);
        $month = $months[$parts[1]] ?? null;
        $year  = $parts[2]; // ปี พ.ศ. อยู่แล้ว

        if (!$month) return null;

        return $year . $month . $day; // คืนค่าเป็น YYYYMMDD
    }

    public function thaiDateNow()
    {
        // วันที่ปัจจุบัน (พ.ศ.)
        $day   = date('d');
        $month = date('m');
        $year  = date('Y') + 543; // แปลง ค.ศ. → พ.ศ.

        return $year . $month . $day; // YYYYMMDD
    }

    // //ทดสอบ
    // public function SaveData(Request $request)
    // {
    //     // return response()->json($request->all());
    //     // $dataArr = json_decode($request->input('dataArr'), true);

    //     // // ลองดูว่ามีอะไร
    //     // return response()->json([
    //     //     'all' => $request->all(),
    //     //     'dataArr' => $dataArr
    //     // ]);
    //     //กำหนดข้อความ Validation
    //     $messages = [
    //         'idPsSend.required' => 'กรุณาเลือกผู้ส่ง',
    //         'idPsRec.required'  => 'กรุณาเลือกผู้รับ',
    //         'labCheck.required' => 'กรุณาเลือกการส่งเมล็ดตัวอย่างเข้า Lab',
    //         'RecPack.required'  => 'กรุณาระบุจำนวนรับ',
    //         'GradUser.required'  => 'กรุณาเลือกเกรดเมล็ด',
    //     ];

    //     //สร้าง Validator
    //     $validator = Validator::make($request->all(), [
    //         'idPsSend' => 'required',
    //         'idPsRec'  => 'required',
    //         'labCheck' => 'required',
    //         'GradUser' => 'required',
    //         'RecPack'  => 'required',
    //     ], $messages);

    //     $dateText = $request->input('JrDate'); // เช่น "18 สิงหาคม 2568"
    //     $DocCode = collect(DB::select(
    //         'EXEC mdCodeGetFormat @IdCompb = ?, @rCode = ? OUTPUT',
    //         [$request->input('idCompb'), '']
    //     ))->first();

    //     // เรียกใช้ฟังก์ชันแปลงวันที่
    //     $JrDate = $this->thaiDateToNumber($dateText);
    //     $DateNow = $this->thaiDateNow();

    //     //ถ้า Validation ผิด
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => 422,
    //             'errors' => $validator->errors(),
    //         ]);
    //     }

    //     // ตรวจสอบว่ามี DocCode
    //     if ($DocCode && isset($DocCode->DocCode)) {
    //         // ตัด 3 ตัวแรกออก
    //         $newDocCode = substr($DocCode->DocCode, 3); 
    //     }
    //     //  return response()->json($newDocCode);

      
    //     $farmerCheck = $request->input('farmerCheck');
    //     if($farmerCheck == 1){
    //         $idPsSend = 0;
    //     } else {
    //         $idPsSend = $request->input('idPsSend');
    //     }

    //     //จำลองการบันทึก (ไม่กระทบจริง)
    //     $dataTest = [
    //         'JrCode'       => $DocCode,
    //         'RefNum'       => $request->input('RefNum'),
    //         'Note'         => $request->input('Note'),
    //         'JrDate'       => $JrDate,
    //         'DocDate'      => $DateNow,
    //         'idJN'         => $request->input('idJob'),
    //         'RecPack'      => $request->input('RecPack'),
    //         'JrHumidRai'   => $request->input('JrHumidRai'),
    //         'JrHumidStore' => $request->input('JrHumidStore'),
    //         'JrRecRai'     => $request->input('JrRecRai'),
    //         'JrRecStore'   => $request->input('JrRecStore'),
    //         'GetAmount'    => $request->input('JrRecStore'),
    //         // 'idPsSend'     => $request->input('idPsSend'),
    //         'idPsSend'     => $idPsSend,
    //         'idPsRec'      => $request->input('idPsRec'),
    //         'idUser'       => $request->input('idUser'),
    //         'GradUser'     => $request->input('GradUser'),
    //         'Grad'         => 'A : A',
    //         'PointsRai'    => 100,//$request->input('Point'),
    //         'PointsStore'  => 100,//$request->input('Point'),
    //     ];


    //     // $dataTest2 = [
    //     //     'idJobRec'     => 1, // $idJobRec คือidที่บันทึกตารางแรก
    //     //     'PackCode'       => $newDocCode, // รหัสแพ็กเกจ (คำนวณจากรหัส + รหัสเอกสาร โดยตัด 2 ตัวหน้า)
    //     //     'PackKgRai'         => $request->input('JrRecRai'), //น้ำหนักที่ไร่ (หน่วย: กก.)
    //     //     'HumidRai'       => $request->input('JrHumidRai'), // ความชื้นที่ไร่ (หน่วย: %)
    //     //     'PackKgStore'     => $request->input('JrRecStore'), //หน่วย: กก.) 
    //     //     'HumidStore'         => $request->input('JrHumidRai'), //ความชื้นที่คลัง (หน่วย: %)
    //     //     'Kg_'      => $request->input('JrRecStore'), // น้ำหนักที่คลัง (หน่วย: กก.) อาจซ้ำกับ PackKgStore
    //     //     'Humid_'   => $request->input('JrHumidRai'), // ความชื้นที่คลัง (หน่วย: %) อาจซ้ำกับ HumidStore
    //     // ];

    //     $dataArr = json_decode($request->input('dataArr'), true);
    //     $allData = []; 
    //     foreach ($dataArr as $item) {
    //         $allData[] = [
    //             'idJobRec'    => 123, 
    //             'PackCode'    => $item['PN'] . '-' . $newDocCode, //รหัส
    //             'PackKgRai'   => $item['farmWeight'], //ความชื้นที่ไร่%
    //             'HumidRai'    => $item['farmMoisture'], //ความชื้นที่ไร่%
    //             'PackKgStore' => $item['storeWeight'],  //นน.ที่คลัง/กก.
    //             'HumidStore'  => $item['storeMoisture'], //HumidStore
    //             'Kg_'         => $item['storeWeight'], //นน.ที่คลัง/กก.
    //             'Humid_'      => $item['storeMoisture'], //ความชื้นที่คลัง%
    //         ];
    //     }

    //     $dataTest2 =  $allData;

    //     //ส่งกลับ JSON ให้ Frontend ใช้งานเหมือนบันทึกจริง
    //     return response()->json([
    //         'status'  => 200,
    //         'message' => 'ทดสอบบันทึกข้อมูลสำเร็จ (ไม่กระทบจริง)',
    //         // 'data'    => $dataTest,
    //         // 'data'    => [$dataTest,$dataTest2],
    //         'data'    => [$dataTest,$dataTest2],
    //     ]);
    // }

    public function SelectSeason(Request $request)
    {
        $season = DB::table('dSeasonOfProduce')
            ->where('idSeasonPd', $request->Season)
            ->first();

        if ($season) {
            session([
                'Season' => $season->idSeasonPd,
                'SeasonName' => $season->SeasonName
            ]);
        }

        return response()->json(['success' => true]);
    }


    //ทดสอบ
    public function SaveData(Request $request)
    {
        // return response()->json($request->all());
        try {
            $dataArr = json_decode($request->input('dataArr'), true);
            $request->merge(['dataArr' => $dataArr]); // ทำให้ Validator มองเป็น array

            $messages = [
                'idPsSend.required' => 'กรุณาเลือกผู้ส่ง',
                'idPsRec.required'  => 'กรุณาเลือกผู้รับ',
                'labCheck.required' => 'กรุณาเลือกการส่งเมล็ดตัวอย่างเข้า Lab',
                'RecPack.required'  => 'กรุณาระบุจำนวนรับ',
                'GradUser.required'  => 'กรุณาเลือกเกรดเมล็ด',
                // 'grade.required'  => 'กรุณาเลือกเกรด',
                'dataArr.*.grade.required' => 'กรุณาเลือกเกรดในตารางให้ครบทุกแถว', // <-- เพิ่มตรงนี้
            ];
            $validator = Validator::make($request->all(), [
                'idPsSend' => 'required',
                'idPsRec'  => 'required',
                'labCheck' => 'required',
                'GradUser' => 'required',
                // 'grade' => 'required',
                'RecPack'  => 'required',
                'dataArr.*.grade' => 'required', // <-- ตรวจทุกแถว
            ], $messages);

            $dateText = $request->input('JrDate'); // เช่น "18 สิงหาคม 2568"
            $DocCode = collect(DB::select(
                'EXEC mdCodeGetFormat @IdCompb = ?, @rCode = ? OUTPUT',
                [$request->input('idCompb'), '']
            ))->first();

            // เรียกใช้ฟังก์ชันแปลงวันที่
            $JrDate = $this->thaiDateToNumber($dateText);
            $DateNow = $this->thaiDateNow();

            //ถ้า Validation ผิด
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'errors' => $validator->errors(),
                ]);
            }
            // return response()->json($request->all());

            // ตรวจสอบว่ามี DocCode
            if ($DocCode && isset($DocCode->DocCode)) {
                // ตัด 3 ตัวแรกออก
                $newDocCode = substr($DocCode->DocCode, 3); 
            }
            //  return response()->json($newDocCode);
        
            $farmerCheck = $request->input('farmerCheck');
            if($farmerCheck == 1){
                $idPsSend = 0;
            } else {
                $idPsSend = $request->input('idPsSend');
            }

            $JR = new PdIndexJobRec();
            $JR->JrCode = $DocCode->DocCode;
            $JR->RefNum = $request->input('RefNum');
            $JR->Note = $request->input('Note');
            $JR->JrDate = $JrDate;
            $JR->DocDate = $DateNow;
            $JR->idJN = $request->input('idJob');
            $JR->RecPack = $request->input('RecPack');
            $JR->JrHumidRai =$request->input('JrHumidRai');
            $JR->JrHumidStore = $request->input('JrHumidStore');
            $JR->JrRecRai = $request->input('JrRecRai');
            $JR->JrRecStore = $request->input('JrRecStore');
            $JR->GetAmount = $request->input('JrRecStore');
            $JR->idPsSend = $idPsSend;
            $JR->idPsRec = $request->input('idPsRec');
            $JR->idUser = $request->input('idUser');
            $JR->GradUser = $request->input('GradUser');
            $JR->Grad = 'A : A';
            $JR->PointsRai = 100;
            $JR->PointsStore = 100;
            $JR->save();
            info('ข้อมูลจำลอง1:', $JR->toArray()); 

            $newIdJobRec = $JR->idJobRec;

            // $dataArr = json_decode($request->input('dataArr'), true);

            $allRP = [];
            foreach ($dataArr as $item) {
                $RP = new PdIndexJobRecPack();
                $RP->idJobRec    = $newIdJobRec;
                // $RP->PackCode    = $item['PN'] . '-' . $newDocCode;
                $RP->PackCode    = $item['PN'];
                $RP->PackKgRai   = $item['farmWeight'];
                $RP->HumidRai    = $item['farmMoisture'];
                $RP->PackKgStore = $item['storeWeight'];
                $RP->HumidStore  = $item['storeMoisture'];
                $RP->Kg_         = $item['storeWeight'];
                $RP->Humid_      = $item['storeMoisture'];

                $RP->Grade      = $item['grade'];
                $RP->NumRef      = $item['NumRef'];
                
                info('ข้อมูลจำลอง2:', $RP->toArray()); 
                $allRP[] = $RP->toArray(); // เก็บแต่ละแถว
                $RP->save(); // บันทึกลง DB
            }
             
            // บันทึก Audit Log สำหรับการสร้างข้อมูลรับเมล็ด
            AuditLogService::log(
                'CREATE',
                'spm_seed_job_rec',
                $newIdJobRec,
                null,
                $JR->toArray(),
                'บันทึกรับเมล็ดจาก JOB: ' . ($request->input('JobNo') ?? $request->input('idJob')) . ' (รหัสเอกสาร: ' . $JR->JrCode . ')'
            );

            AuditLogService::log(
                'CREATE',
                'spm_seed_job_rec_pack',
                $newIdJobRec,
                null,
                ['packs' => $allRP],
                'บันทึกรายการกระสอบรับเมล็ด จำนวน ' . count($allRP) . ' กระสอบ สำหรับรหัสเอกสาร: ' . $JR->JrCode
            );

            return response()->json([
                'success' => true,
                'message' => 'บันทึกเรียบร้อย',
                'data' => [
                    $JR->toArray(),
                    'RP' => $allRP
                ]
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage(),
                'data' => [
                   
                ]
            ], 500);
        }
    }


    public function UpdateDBNote(Request $request){
        // return response()->json($request->all());

        // $j = $request->input('idJob'); 
        // $idJ = collect(DB::select("SELECT * FROM PdIndexJobDt WHERE idJob = $j"))->first();
        // // return response()->json($idJ);


        // $dataTestNote = [
        //     'stRecBeforeSet'=> 1,
        //     $idJ,
        //     'NoteRecBeforeSet'=> $request->input('NoteRecBeforeSet'),
        // ];

        // return response()->json([
        //     'message' => 'ทดสอบบันทึกสคริป',
        //     'data'    => $dataTestNote,
        // ]);

        DB::beginTransaction(); // เริ่ม transaction
            // รับค่าจาก request
            $idJob = $request->input('idJob'); 

            // ดึงข้อมูลก่อนอัพเดท
            $idJ = collect(DB::select("SELECT * FROM PdIndexJobDt WHERE idJob = ?", [$idJob]))->first();

            // ทำการอัพเดท
            $affected = DB::table('PdIndexJobDt')
                ->where('idJob', $idJob)
                ->update([
                    'stRecBeforeSet'  => 1,
                    'NoteRecBeforeSet'=> $request->input('NoteRecBeforeSet')
                ]);

            // Rollback ไม่ให้บันทึกจริง
            // DB::rollBack();
            // // ยืนยันการบันทึกจริง
            DB::commit();

            // บันทึก Audit Log สำหรับการอัพเดทหมายเหตุ/ข้ามสถานะ
            AuditLogService::log(
                'UPDATE',
                'spm_seed_job_note',
                $idJob,
                ['old_note' => $idJ->NoteRecBeforeSet ?? null, 'old_stRecBeforeSet' => $idJ->stRecBeforeSet ?? null],
                ['new_note' => $request->input('NoteRecBeforeSet'), 'stRecBeforeSet' => 1],
                'บันทึกหมายเหตุรับเมล็ดก่อนสถานะ สำหรับ idJob: ' . $idJob
            );

            // ส่งกลับ
            return response()->json([
                'message' => 'ทดสอบบันทึกสคริป',
                'dataBefore'=> $idJ, // ข้อมูลก่อนอัพเดท
                'rowsUpdated' => $affected, // จำนวนแถวที่โดน update
            ]);
    }

//   public function showQr(Request $request)
//     {
//         $url = url("/Seed/SeedDetail/{$request}");
        
//         // ใช้ new Builder() แทน Builder::create()
//         $result = (new Builder())
//             ->writer(new PngWriter())
//             ->data($url)
//             ->size(200)
//             ->margin(10)
//             ->build();
        
//         // แปลงเป็น Data URI
//         $qrCodeString = $result->getDataUri();
        
//         return response()->json($qrCodeString);    
//     }

    public function SeedDetail($id){
        // return response()->json($request->all());

        // $id = $request->input('idJobRecPack'); 
        // $id = $request; 

        $data['Detail_sd'] = collect(DB::SELECT("SELECT * FROM vPdIndexJobRecPack WHERE idJobRecPack = ?"  , [$id]))->first();

        // dd($data['Detail_sd']);
        return view('Seeds.SeedDetail' ,$data);        
    }


    // public function Show_Detail(Request $request){
    //     // return response()->json($request->all());

    //     $id = $request->input('idJobRecPack'); 

    //     $data['Detail_sd'] = collect(DB::SELECT("SELECT * FROM vPdIndexJobRecPack WHERE idJobRecPack = ?"  , [$id]))->first();

    //     return response()->json( $data);       
    // }

}






