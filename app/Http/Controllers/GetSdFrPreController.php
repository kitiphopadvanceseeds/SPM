<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class GetSdFrPreController extends Controller
{

    public function GetSdFrPre()
    {

        return view('Seeds.GetSdFrPre');
    }
    public function DB_GetSdFrPre(Request $request)
    {
        // return response()->json($id->all());
        // $idComp = $request->input('idComp');

        // $data['GetSdFrPre'] = collect(DB::select("SELECT comp.idComp, comp.CompName, m.parentid 
        //                                 FROM [PchInvAndProject].[dbo].[dCompany] AS comp 
		// 								LEFT JOIN [PchInvAndProject].[devsk].[dGroupCompMap] m ON comp.idComp = m.idcomp 
        //                                 WHERE m.parentid IS NOT NULL AND ISNULL(comp.stDel,0)= 0 
		// 								AND m.idComp =  $idComp
		// 								ORDER BY  m.parentid ,comp.idComp ASC "))->first();

        $data['GetSdFrPre'] = DB::select("SELECT idIndex,idJob,JobNo,DateReceive_ as DateReceive_,StrainCode,SeedTypeName as PlantName,FmName,ZoneName_,idCompb 
                                        FROM vPdIndexJobDtRec  
                                        WHERE  idComp = 3 And idSeasonPd=96 And idJobLine <> '9'   And ((DateReceive_ > '25680612') OR (DateHarvest_ > '25680612' And  DateReceive_ < '25680612')) 
                                        ORDER BY DateMete ");

        // $data['GetSdFrPre'] = collect(DB::select("SELECT comp.idComp, comp.CompName, m.parentid 
        //                                 FROM [PchInvAndProject].[dbo].[dCompany] AS comp 
        // 								LEFT JOIN [PchInvAndProject].[devsk].[dGroupCompMap] m ON comp.idComp = m.idcomp 
        //                                 WHERE m.parentid IS NOT NULL AND ISNULL(comp.stDel,0)= 0 
        // 								AND m.idComp =  $idComp
        // 								ORDER BY  m.parentid ,comp.idComp ASC "))->first();

        return response()->json($data);
    }
}
