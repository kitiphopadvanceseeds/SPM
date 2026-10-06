<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('Home.home');
    }

    // เลือกบริษัทและฤดู
    public function selectComp(Request $request)
    {
        // return response()->json($request->all());
        $idComp = $request->input('idComp');
        $idProvince = $request->input('idProvince');

        $data['nav'] = 'product-list';
        $data['selectCompany'] = collect(DB::select(" SELECT distinct dc.idComp,dc.CompName,dc.CompCode ,vc.idCompb , vc.idProvince, vc.BrnName + ' ' + ProvinceName as BrnName FROM dCompany AS dc
                                                LEFT JOIN vCompBranch as vc ON vc.idComp = dc.idComp WHERE dc.idComp <> 0  AND dc.idComp <> 0 And dc.stDel is null AND dc.idComp = ? AND vc.idProvince = ?" , [$idComp,$idProvince]))->first();
        if (!empty($data['selectCompany'])) {
            session([
                'idComp' => $data['selectCompany']->idComp,
                'CompName' => $data['selectCompany']->CompName,
                'BrnName' => $data['selectCompany']->BrnName,
                'idProvince' => $data['selectCompany']->idProvince,
            ]);
        }
        // $data['selectCompany'] = collect(DB::select("SELECT comp.idComp, comp.CompName, m.parentid ,comp.idCompb
        //                                 FROM [PchInvAndProject].[dbo].[dCompany] AS comp 
		// 								LEFT JOIN [PchInvAndProject].[devsk].[dGroupCompMap] m ON comp.idComp = m.idcomp 
        //                                 WHERE m.parentid IS NOT NULL AND ISNULL(comp.stDel,0)= 0 
		// 								AND m.idComp =  ?
		// 								ORDER BY  m.parentid ,comp.idComp ASC " , [$idComp]))->first();
        // if (!empty($data['selectCompany'])) {
        //     session([
        //         'idComp' => $data['selectCompany']->idComp,
        //         'CompName' => $data['selectCompany']->CompName,
        //     ]);
        // }

        $Season = $request->input('Season');

        $data['Season'] = collect(DB::SELECT("SELECT * FROM dSeasonOfProduce WHERE idSeasonPd = $Season "))->first();
        if (!empty($data['Season'])) {
            session([
                'Season' => $data['Season']->idSeasonPd,
                'SeasonName' => $data['Season']->SeasonName,
            ]);
        }

        return response()->json();
    }



    public function comp()
    {

        $data['Season'] = DB::SELECT("SELECT * FROM dSeasonOfProduce");

        // dd( $data['Season']);
        return view('Home.comp', $data);
    }


    public function CompeName()
    {
        //ตารางบริษัทอีกอันเผื่อเลือกใช้ syndCompany
        $data['CompeName'] = DB::select("SELECT distinct dc.idComp,dc.CompName,dc.CompCode ,vc.idCompb , vc.idProvince, vc.BrnName + ' ' + ProvinceName as BrnName FROM dCompany AS dc
                                                LEFT JOIN vCompBranch as vc ON vc.idComp = dc.idComp WHERE dc.idComp <> 0  AND dc.idComp <> 0 And dc.stDel is null");
        return response()->json($data);
    }
    // public function CompeName()
    // {
    //     //ตารางบริษัทอีกอันเผื่อเลือกใช้ syndCompany
    //     $data['CompeName'] = DB::select("SELECT comp.idComp, comp.CompName, m.parentid 
    //                                             FROM [PchInvAndProject].[dbo].[dCompany] AS comp LEFT JOIN [PchInvAndProject].[devsk].[dGroupCompMap] m ON comp.idComp = m.idcomp 
    //                                             WHERE m.parentid IS NOT NULL AND ISNULL(comp.stDel,0)= 0 ORDER BY  m.parentid ,comp.idComp ASC");
    //     return response()->json($data);
    // }

    

    //  public function CompMain()
    // {
    //     //ตารางบริษัทอีกอันเผื่อเลือกใช้ syndCompany
    //     $data['CompeName'] = DB::select("SELECT comp.idComp, comp.CompName, m.parentid 
    //                                             FROM [PchInvAndProject].[dbo].[dCompany] AS comp LEFT JOIN [PchInvAndProject].[devsk].[dGroupCompMap] m ON comp.idComp = m.idcomp 
    //                                             WHERE m.parentid IS NOT NULL AND ISNULL(comp.stDel,0)= 0 ORDER BY  m.parentid ,comp.idComp ASC");
    //     return response()->json($data);
    // }
    //  public function CompMajor()
    // {
    //     //ตารางบริษัทอีกอันเผื่อเลือกใช้ syndCompany
    //     $data['CompeName'] = DB::select("SELECT comp.idComp, comp.CompName, m.parentid 
    //                                             FROM [PchInvAndProject].[dbo].[dCompany] AS comp LEFT JOIN [PchInvAndProject].[devsk].[dGroupCompMap] m ON comp.idComp = m.idcomp 
    //                                             WHERE m.parentid IS NOT NULL AND ISNULL(comp.stDel,0)= 0 ORDER BY  m.parentid ,comp.idComp ASC");
    //     return response()->json($data);
    // }
}
