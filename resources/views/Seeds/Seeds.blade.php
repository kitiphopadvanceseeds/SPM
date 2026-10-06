@extends('layouts.style')
@section('style')
    <style>
        @media (max-width: 1180px) {
            .cardMT {
                padding-top: 8% !important;
            }
        }

        @media (max-width: 1366px) {
            .cardMT {
                padding-top: 8% !important;
            }
        }

        @media (max-width: 576px) {
            .cardMT {
                padding-top: 1% !important;
            }
        }

        .btn-link.company-link {
            padding: 12px 15px;
            color: #333;
        }

        .btn-link.company-link:hover {
            background-color: #3559c4;
            color: white;
        }

        .w-100 {
            white;
            width: 100% !important;
        }

        .btnSave {
            background: linear-gradient(135deg, #198754cc, #005923e0) !important;
            color: white;
            border: none;
            /* ลบ border ถ้าไม่ต้องการเส้นขอบ */
        }

        .btnSave:hover {
            background: linear-gradient(135deg, #02c469cc, #00ff66e0) !important;
            color: white;
        }


        .loader {
            width: 48px;
            height: 48px;
            border: 5px solid #FFF;
            border-bottom-color: transparent;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 480px) {
            .textName {
                min-width: 400px !important;
                text-align: center !important;
            }

            .textTreasury {
                min-width: 400px !important;
                text-align: center !important;
            }
        }

        /* @media (max-width: 768px) {
                            #contentToToggle {
                                display: none;
                            }
                        } */

        .icon-size {
            width: 20px;
            height: 20px;
        }

        #RequistionTable {
            font-size: 14px;
        }

        element.style {
            min-width: 70px;
        }

        .grow img {
            transition: transform 0.3s ease;
        }

        .grow img:hover {
            -webkit-transform: scale(1.2);
            -ms-transform: scale(1.2);
            transform: scale(1.2);
            transition: transform 0.3s ease;
        }

        .container {
            display: flex;
            justify-content: flex-end;
        }

        /* เฉพราะแสดงแค่เดือนปี */
        .month-year-only .ui-datepicker-calendar {
            display: none !important;
        }

        .month-year-only .ui-datepicker-prev,
        .month-year-only .ui-datepicker-next {
            display: none !important;
        }

        .ui-datepicker select.ui-datepicker-month,
        .ui-datepicker select.ui-datepicker-year {
            width: 100% !important;
        }

        .month-year-only {
            width: auto !important;
            padding: 10px;
        }

        /* ทำให้แน่ใจว่า calendar จะแสดงสำหรับ date-picker */
        .ui-datepicker:not(.month-year-only) .ui-datepicker-calendar {
            display: table !important;
        }

        .month-year-only .ui-datepicker-current {
            display: none !important;
            /* ซ่อนปุ่ม "Today" */
        }



        /* ซ่อนส่วนที่ไม่ต้องการใน year-only */
        .year-only .ui-datepicker-calendar,
        .year-only .ui-datepicker-month,
        .year-only .ui-datepicker-current,
        .year-only .ui-datepicker-next,
        .year-only .ui-datepicker-prev,
        .year-only .ui-datepicker-buttonpane,
        .year-only .ui-datepicker tbody {
            display: none !important;
        }

        /* ปรับขนาด dropdown ปีให้แสดงเต็ม */
        .year-only .ui-datepicker {
            width: auto !important;
            padding: 10px;
            text-align: center;
            /* จัดข้อความให้อยู่ตรงกลาง */
            border: 1px solid #ced4da;
            /* เพิ่มเส้นขอบ */
            border-radius: 5px;
            /* เพิ่มขอบมน */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* เพิ่มเงา */
        }

        .year-only select.ui-datepicker-year {
            width: 100% !important;
            font-size: 16px;
            padding: 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") no-repeat right 10px center;
            padding-right: 30px;
        }

        /* ซ่อนปฏิทินใน month-year-only */
        .year-only:not(.month-year-only) .ui-datepicker-calendar {
            display: none !important;
        }

        .ms-2 {
            width: 100px !important;
        }

        .ms-02 {
            width: 150px !important;
        }
    </style>
    <style>
        .parent {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            grid-template-rows: repeat(5, 1fr);
            gap: 8px;
            /* height: 550px; */
            height: 620px;
        }

        .div1 {
            grid-column: span 3 / span 3;
            grid-row: span 5 / span 5;

        }

        .div2 {
            grid-column: span 2 / span 2;
            grid-row: span 5 / span 5;
            grid-column-start: 4;
            background-color: #efefef;
        }

        @media (max-width: 992px) {
            .parent {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: auto;
            }

            .div1,
            .div2 {
                grid-column: span 2 / span 2;
                grid-row: auto;
            }
        }


        @media (max-width: 480px) {
            .parent {
                grid-template-columns: 1fr;
                height: 100%;
            }
        }

        .checkLayout {
            margin-left: 10%;
        }
    </style>
    <style>
        .seed-inspection-table .header-title h3 {
            margin: 5px 0 0 0;
            font-size: 18px;
            font-weight: normal;
        }

        .seed-inspection-table table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        .seed-inspection-table th,
        .seed-inspection-table td {
            border: 1px solid #959595;
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }

        .seed-inspection-table thead th {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: center;
        }

        .seed-inspection-table td:first-child {
            text-align: center;
        }

        .seed-inspection-table .col-ลำดับ {
            width: 8%;
        }

        .seed-inspection-table .col-เหตุการณ์ {
            width: 64%;
        }

        .seed-inspection-table .col-คะแนน {
            width: 14%;
        }

        /* .seed-inspection-table .highlight-blue {
                            background-color: #0078d7;
                            color: white;
                        }  */

        .seed-inspection-table .highlight-red {
            background-color: #ea9999;
            color: #333;
        }

        .grade-selector-wrapper {
            text-align: center;
            display: flex;
            justify-content: center;
        }

        #RoomDataTableItem tbody tr:hover td {
            background-color: #ababab9c !important;
            cursor: pointer;
        }

        /* ป้องกันการเลือกข้อความ */
        .no-select {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .error-text {
            color: red;
            font-size: 16px;
            /* border: red;        */
            /* border: 5px solid #FF0000; */
        }

        .dropdown-select {
            appearance: auto;
            -webkit-appearance: auto;
            -moz-appearance: auto;
            cursor: pointer;
        }

        .error-border {
            border: 2px solid red !important;
        }
    </style>
      {{-- <style>
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            text-align: center;
            max-width: 400px;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .qr-box {
            margin-bottom: 30px;
        }

        .qr-box img {
            border: 3px solid #f0f0f0;
            border-radius: 10px;
            max-width: 100%;
            height: auto;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Sarabun', sans-serif;
            margin: 5px;
        }

        .btn-print {
            background: #667eea;
            color: white;
        }

        .btn-print:hover {
            background: #5568d3;
            transform: translateY(-2px);
        }

        .btn-close {
            background: #e0e0e0;
            color: #333;
        }

        .btn-close:hover {
            background: #d0d0d0;
            transform: translateY(-2px);
        }

        @media print {
            body {
                background: white;
            }
            .btn {
                display: none;
            }
            .container {
                box-shadow: none;
            }
        }
    </style> --}}
@endsection

@section('content')


{{-- <pre>
    {{ print_r(session()->all(), true) }}
</pre> --}}

    <div class="card mt-2">
        <div class="card">
            <div class="card-header"
                style="background-color: #dddddd; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    {{-- <i class="bi bi-box-seam"></i> --}}
                    {{-- <img src="{{ asset('img/clipart3221312.png') }}" alt="รับเมล็ดจาก JOB" style="height:25px;"> --}}
                    <img id="iconShow" src="-" alt="icon" style="height:25px;">
                    {{-- รับเมล็คจาก JOB --}}
                    <span id="textShow"></span>
                </div>
            </div>

            <div class="card-body p-2 " id="contentToToggle">
                <div class="row g-3">
                    <!-- ฤดูปลูก -->
                    {{-- <div class="col-12 col-md-3">
                            <div class="mt-1">
                                <div class="d-flex align-items-center flex-nowrap">
                                    <input class="form-check-input me-1" type="checkbox" id="companyCheck" name="CheckGroup">
                                    <label class="form-label mb-0 me-1 text-nowrap">ฤดูปลูก</label>
                                    <div class="input-group flex-grow-1">
                                        <input type="hidden" class="form-control" id="Comp_Id" name="Comp_Id" 
                                                value="{{ session('Season') }}" readonly>

                                        <input type="text" class="form-control form-control-sm" id="Comp_Name" 
                                            name="Comp_Name" value="{{ session('SeasonName') }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    <div class="col-12 col-md-3">
                        <div class="mt-1">
                            <div class="d-flex align-items-center flex-nowrap">
                                <label class="form-label mb-0 me-1 text-nowrap">ฤดูปลูก</label>
                                <div class="input-group flex-grow-1">
                                    <select id="Season" name="Season" class="form-control form-control-sm">
                                        @foreach ($Season as $item)
                                            <option value="{{ $item->idSeasonPd }}"
                                                {{ session('Season') == $item->idSeasonPd ? 'selected' : '' }}>
                                                {{ $item->SeasonCode }} : {{ $item->SeasonName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- เกษตรกร -->
                    <div class="col-12 col-md-3">
                        <div class="mt-1">
                            <div class="d-flex align-items-center flex-nowrap">
                                <label class="form-label mb-0 me-1 text-nowrap">เกษตรกร</label>
                                <div class="input-group flex-grow-1">
                                    <input type="hidden" class="form-control form-control-sm" id="idFarmer"
                                        name="idFarmer" readonly>
                                    <input type="text" class="form-control form-control-sm" id="Nsearch_Emp" readonly>
                                    <button class="btn btn-outline-secondary btn-sm" type="button" id="search_Emp">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- ปุ่มค้นหา -->
                    <div class="col-12 col-md-3">
                        <div class="mb-1">
                            <button type="button" onclick="SearchData()" class="btn btn-success">แสดงข้อมูล</button>
                            <button type="button" onclick="SearchCancel()" class="btn btn-danger">ยกเลิกแสดง</button>
                        </div>
                    </div>
                </div>
                <hr class="my-2">
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-center flex-nowrap">
                        <label class="form-label mb-0 me-1 text-nowrap">ค้นหา</label>
                        <div class="input-group flex-grow-1">
                            <input type="text" class="form-control form-control-sm" id="SearchMaterial"
                                name="SearchMaterial" autocomplete="off">
                        </div>
                    </div>
                </div>
                <hr class="my-2">
            </div>
        </div>
        <div class="table-responsive">
            <table id="RequistionTable" class="table table-striped d-none" style="width:100%">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center" style="min-width: 40px !important;">รับ</th>
                        <th class="custom_w1 jobno text-center" style="min-width: 40px;">JobNo.</th>
                        <th class="custom_w2 expect_date text-center" style="min-width: 140px;">วันที่คาดว่าจะรับเมล็ด</th>
                        <th class="custom_w3 prod_code text-center" style="min-width: 120px;">รหัสผลิต</th>
                        <th class="custom_w4 plant_name text-center" style="min-width: 120px;">พืช</th>
                        <th class="custom_w5 farmer_name text-center" style="min-width: 190px;">เกษตรกร</th>
                        <th class="custom_w6 area text-center" style="min-width: 120px;">พื้นที่</th>
                        <th class="custom_w7 area text-center" style="min-width: 120px;">จนท.</th>
                    </tr>
                </thead>
                <tbody id="DataSeeds">

                </tbody>
            </table>
        </div>
        <div class="table-responsive">
            <table id="RequistionTableGet" class="table table-striped d-none" style="width:100%;">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center" style="max-width: 40px !important; width: 40px; min-width: 40px">พิมพ์</th>
                        <th class="custom_w1 jobno text-center">No.</th>
                        <th class="custom_w2 expect_date text-center" style="min-width: 120px;">ประเภทส่งเสริม</th>
                        <th class="custom_w2 expect_date text-center" style="min-width: 80px;">ลำดับชุดส่ง</th>
                        <th class="custom_w3 prod_code text-center" style="min-width: 120px;">ฤดูผลิต</th>
                        <th class="custom_w4 plant_name text-center" style="min-width: 120px;">สถานที่ปลูก</th>
                        <th class="custom_w5 farmer_name text-center" style="min-width: 190px;">ส่งเสริม/SUB</th>
                        <th class="custom_w6 area text-center" style="min-width: 120px;">เกรดส่งเสริม</th>
                        <th class="custom_w7 area text-center" style="min-width: 120px;">วันที่รับเมล็ด</th>
                        <th class="custom_w8 area text-center" style="min-width: 260px;">ชื่อเกษตรกร</th>
                        <th class="custom_w9 area text-center" style="min-width: 120px;">ชนิดพืช</th>
                        <th class="custom_w10 area text-center" style="min-width: 120px;">รหัสสินค้า</th>
                        <th class="custom_w11 area text-center" style="min-width: 120px;">รหัสผลิต</th>
                        <th class="custom_w12 area text-center" style="min-width: 120px;">นน.รับเกษตรกร</th>
                        <th class="custom_w13 area text-center" style="min-width: 120px;">นน.รับคลัง</th>
                        <th class="custom_w14 area text-center" style="min-width: 120px;">คช.ที่ไร่%</th>
                        <th class="custom_w15 area text-center" style="min-width: 120px;">คช.ที่คลัง%</th>
                    </tr>
                </thead>
                <tbody id="DataGetSeeds">

                </tbody>
            </table>
        </div>
    </div>
    {{-- {{ dd(session('Season'), session('SeasonName')) }} --}}

    {{-- Modal --}}
    <div class="modal fade" id="emp_modal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-ml">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: rgb(25, 47, 122);
                    background: linear-gradient(135deg, #198754cc, #005923e0);">
                    <i class="bi bi-person" style="font-size: 20px; color: white; margin-right: 10px;"></i>
                    <h4 class="modal-title" style="color: white !important;">
                        ค้นหาเกษตรกร
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: white;"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="datatableEmp" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="min-width: 50px;">เลือก</th>
                                    <th class="text-center" style="min-width: 200px;">ชื่อ-นามสกุล</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyemp"></tbody>
                        </table>
                        {{-- <button class="btn btn-success " type="button" id="btn_addEmp">ค้นหาพนักงาน</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal ผู้ทำรายการ/ส่ง/รับ --}}
    <div class="modal fade" id="User_modal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true"
        style="z-index: 1059 !important; background-color: #00000063;">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header"
                    style="background: rgb(25, 47, 122);
                    background: linear-gradient(135deg, #198754cc, #005923e0);">
                    <i class="bi bi-person" style="font-size: 20px; color: white; margin-right: 10px;"></i>
                    <h4 class="modal-title" style="color: white !important;">
                        ค้นหาเกษตรกร
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: white;"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="datatableUser" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="min-width: 50px;">เลือก</th>
                                    <th class="text-center" style="min-width: 200px;">ชื่อ-นามสกุล</th>
                                    <th class="text-center" style="min-width: 200px;">แผนก</th>
                                    <th class="text-center" style="min-width: 200px;">บริษัท</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyUser"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- เลือกเมล็ด --}}
    <div class="modal fade" id="Item_modal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
            <div class="modal-content">

                <form id="SaveData" method="POST" action="/save-data">
                    @csrf
                    {{-- เกรดที่ดึงจากajax --}}
                    <input type="hidden" id="Grade" name="Grade">
                    <div class="modal-header" style="background: linear-gradient(135deg, #198754cc, #005923e0);">
                        <i class="bi bi-box-seam" style="font-size: 20px; color: white; margin-right: 10px;"></i>
                        <h4 class="modal-title" style="color: white !important;">รับเมล็ดจาก JOB</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            style="background-color: white;"></button>
                    </div>

                    <div class="modal-body" style="background-color: #f0f2f5;">
                        <div class="card m-2" style="background-color: #f9f9f9">
                            <div class="card-header"
                                style="background-color: #dddddd; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <img src="{{ asset('img/clipart3221312.png') }}" alt="รับเมล็ดจาก JOB"
                                        style="height:25px;">
                                    ข้อมูล JOB รับเมล็ด
                                </div>
                            </div>

                            <input type="hidden" id="typeShow" name="typeShow">
                            <input type="hidden" id="idJob" name="idJob">
                            <div class="card-body cus-card p-2">
                                <div class="row g-1 align-items-center mb-3">
                                    <div class="row-md-6 col-lg-6">
                                        {{-- <div class="row-md-6 col-lg-3"> --}}
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-2" for="typeSelect">JobNo</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1 mb-1"
                                                    id="JobNo" name="JobNo" autocomplete="off" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-2" for="typeSelect">รหัสผลิต</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="pd_Code" name="pd_Code" autocomplete="off" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-2" for="typeSelect">ฤดูผลิต</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="pd_season" name="pd_season" autocomplete="off" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-2" for="typeSelect">เกษตรกร</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="FarmerName" name="FarmerName" autocomplete="off" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-6">
                                        {{-- <div class="col-md-6 col-lg-3"> --}}
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-2" for="typeSelect">จนท.ส่งเสริม</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="PsName" name="PsName" autocomplete="off" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-2" for="typeSelect">พื้นที่ปลูก</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="ZoneName" name="ZoneName" autocomplete="off" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-2" for="typeSelect">จน.ปลูก</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="MomPack" name="MomPack" autocomplete="off" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-2" for="typeSelect">ประเภทพืช</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="SeedTypeName" name="SeedTypeName" autocomplete="off" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-02"
                                                    for="typeSelect">ประมาณผลผลิตจากการแจกเมล็ด</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1" style="background-color: #fec182"
                                                    id="EstimateW" name="EstimateW" autocomplete="off" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-02"
                                                    for="typeSelect">ประมาณผลผลิตจากจนท.ส่งเสริม</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="" name="" value="0.00" autocomplete="off" style="background-color: #fec182" disabled>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="col-md-6 col-lg-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-02"
                                                    for="typeSelect">หนี้คงค้างงวดก่อน</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="" name="" value="0.00" autocomplete="off" style="background-color: #fec1c0" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-02"
                                                    for="typeSelect">หนี้ฤดูผลิตนี้</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="" name="" value="0.00" autocomplete="off" style="background-color: #fec1c0" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-02"
                                                    for="typeSelect">ยอดเบิกโสหุ้ย</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="" name="" value="0.00" autocomplete="off" style="background-color: #fec1c0" disabled>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="form-check d-flex align-items-center"
                                                style="margin-bottom: 0; padding-left: 5px;">
                                                <label class="form-check-label ms-02"
                                                    for="typeSelect">รวมหนี้ทั้งหมด</label>
                                            </div>
                                            <div class="input-group flex-grow-1">
                                                <input type="text" class="form-control form-control-sm mb-1"
                                                    id="" name="" value="0.00" autocomplete="off" style="background-color: #fec1c0" disabled>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="card-body" style="padding-bottom: 50px;">
                            <div class="parent">
                                <div class="div1"> <span class="ms-2"
                                        style="font-weight: 700;">รายละเอียดรับเมล็ด</span>
                                    <div class="modal-content">
                                        <div class="card m-2" style="background-color: #f9f9f9">
                                            <div class="card-body p-3">
                                                <div class="row g-2">
                                                    <!-- แถวที่ 1 -->
                                                    {{-- <input type="text" id="PN_code" name="PN_code" > --}}
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 100px;">รหัสเอกสาร</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="JrCode" name="JrCode" readonly disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 100px;">เลขที่อ้างอิง</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="RefNum" name="RefNum">
                                                        </div>
                                                    </div>

                                                    <!-- แถวที่ 2 -->
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 100px;">หมายเหตุ</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="Note" name="Note">
                                                        </div>
                                                    </div>

                                                    <!-- แถวที่ 3 -->
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 100px;">วันที่รับ</label>
                                                            <div class="d-flex gap-1 w-100">
                                                                <input class="form-control form-control-sm" id="JrDate"
                                                                    name="JrDate">
                                                                </input>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 100px;">จำนวนรับ</label>
                                                            <div class="d-flex gap-2">
                                                                <input type="text"
                                                                    class="form-control form-control-sm " id="RecPack"
                                                                    name="RecPack" style="width: 100px;" value="">
                                                                <span class="align-self-center">กระสอบ</span> <span
                                                                    class="align-self-center error-text"
                                                                    id="text-er"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="modal-body" style="min-height: 150px;"> --}}
                                        <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                            <div class="table-responsive">
                                                <table id="RoomDataTableItem" class="table table-bordered"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">ลำดับ</th>
                                                            <th class="text-center d-none" style="min-width: 150px;">รหัส</th>
                                                            <th class="text-center" style="min-width: 50px;">นน.ที่ไร่/กก.
                                                            </th>
                                                            <th class="text-center" style="min-width: 50px;">ความชื้น
                                                                ที่ไร่%
                                                            </th>
                                                            <th class="text-center" style="min-width: 50px;">นน.ที่
                                                                คลัง/กก.
                                                            </th>
                                                            <th class="text-center" style="min-width: 50px;">
                                                                ความชื้นที่คลัง%
                                                            </th>
                                                            <th class="text-center" style="min-width: 50px;">
                                                                นน.แตกต่าง/กก.
                                                            </th>
                                                            <th class="text-center" style="min-width: 50px;">
                                                                ความชื้นแตกต่าง%
                                                            </th>
                                                            <th class="text-center" style="min-width: 50px;">
                                                                เกรด
                                                            </th>
                                                            <th class="text-center" style="min-width: 50px;">
                                                                อ้างอิง
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ShowDataItem">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        {{-- <div class="card m-2" style="background-color: #f9f9f9">
                                            <div class="card-body p-3">
                                                <div class="row g-2">
                                                    <div class="col-md-4">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0 "
                                                                style="min-width: 150px;">%ความชื้นเฉลี่ย ที่ไร่</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="JrHumidRai" name="JrHumidRai" readonly>%
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0 text-end"
                                                                style="min-width: 120px;">ที่คลัง</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="JrHumidStore" name="JrHumidStore" readonly>%
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 120px;">รวมนน.รับที่ไร่</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="JR_Show" name="JR_Show" disabled>กก.
                                                            <input type="hidden" name="JrRecRai" id="JrRecRai">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 120px;">ชื่อผู้ส่ง</label>
                                                            <div class="input-group flex-grow-1">
                                                                <input type="hidden" class="form-control form-control-sm"
                                                                    id="idPsSend" name="idPsSend">
                                                                <input type="text"
                                                                    class="form-control form-control-sm error-text"
                                                                    id="PsSend_Show" disabled>
                                                                <button class="btn btn-outline-secondary btn-sm"
                                                                    type="button" onclick="search_User(1)">
                                                                    <i class="bi bi-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 120px;">รวมนน.รับที่คลัง</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="JS_Show" name="JS_Show" disabled>กก.
                                                            <input type="hidden" name="JrRecStore" id="JrRecStore">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 120px;">ผู้รับที่คลัง</label>
                                                            <div class="input-group flex-grow-1">
                                                                <input type="hidden" class="form-control form-control-sm"
                                                                    id="idPsRec" name="idPsRec">
                                                                <input type="text"
                                                                    class="form-control form-control-sm error-text"
                                                                    id="PsRec_Show" disabled>
                                                                <button class="btn btn-outline-secondary btn-sm"
                                                                    type="button" onclick="search_User(2)">
                                                                    <i class="bi bi-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 120px;">รวมนน.แตกต่าง</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="dWAll_Show" name="dWAll_Show" disabled>กก.
                                                            <input type="hidden" name="diffWeightAll"
                                                                id="diffWeightAll">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <label class="form-label mb-0"
                                                                style="min-width: 120px;">ผู้ทำรายการ</label>
                                                            <div class="input-group flex-grow-1">
                                                                <input type="hidden" class="form-control form-control-sm"
                                                                    id="idUser" name="idUser"
                                                                    value="{{ session('idPs') }}">
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="User_Show" value="{{ session('name') }}" disabled>
                                                                <button class="btn btn-outline-secondary btn-sm"
                                                                    type="button" onclick="search_User(3)">
                                                                    <i class="bi bi-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <div class="input-group flex-grow-1">
                                                                <input type="hidden" class="form-control form-control-sm"
                                                                    id="idCompb" name="idCompb">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="checkLayout pt-2">
                                                    <div class="checkbox-group d-flex align-items-center gap-2">
                                                        <input type="checkbox" id="labCheck" name="labCheck"
                                                            value="1">
                                                        <label class="checkbox-label mb-0" for="labCheck">
                                                            รับทดสอบใน Lab ออก
                                                        </label>
                                                        <input type="text" id="Point" name="Point"
                                                            style="width: 60px;" class="form-control" value="100">
                                                        <span>หน. / 1 ตัวอย่าง</span> <span id="lab"
                                                            class="error-text">(กรุณาเลือกการส่งเมล็ดตัวอย่างเข้า Lab ***)</span>
                                                    </div>

                                                    <div class="checkbox-group">
                                                        <input type="checkbox" id="farmerCheck" name="farmerCheck"
                                                            value="1">
                                                        <label class="checkbox-label"
                                                            for="farmerCheck">ส่งเมล็ดโดยเกษตรกร</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="div2">
                                    <span class="ms-2" style="font-weight: 700;"></span>
                                    <div class="card m-2" style="background-color: #f9f9f9">
                                        <div class="card-body p-3">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <label class="form-label mb-0 "
                                                            style="min-width: 150px;">%ความชื้นเฉลี่ย ที่ไร่</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="JrHumidRai" name="JrHumidRai" readonly>%
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <label class="form-label mb-0 text-end"
                                                            style="min-width: 120px;">ที่คลัง</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="JrHumidStore" name="JrHumidStore" readonly>%
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <label class="form-label mb-0"
                                                            style="min-width: 120px;">รวมนน.รับที่ไร่</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="JR_Show" name="JR_Show" disabled>กก.
                                                        <input type="hidden" name="JrRecRai" id="JrRecRai">
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <label class="form-label mb-0"
                                                            style="min-width: 120px;">ชื่อผู้ส่ง</label>
                                                        <div class="input-group flex-grow-1">
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="idPsSend" name="idPsSend">
                                                            <input type="text"
                                                                class="form-control form-control-sm error-text"
                                                                id="PsSend_Show" disabled>
                                                            <button class="btn btn-outline-secondary btn-sm"
                                                                type="button" onclick="search_User(1)">
                                                                <i class="bi bi-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <label class="form-label mb-0"
                                                            style="min-width: 120px;">รวมนน.รับที่คลัง</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="JS_Show" name="JS_Show" disabled>กก.
                                                        <input type="hidden" name="JrRecStore" id="JrRecStore">
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <label class="form-label mb-0"
                                                            style="min-width: 120px;">ผู้รับที่คลัง</label>
                                                        <div class="input-group flex-grow-1">
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="idPsRec" name="idPsRec">
                                                            <input type="text"
                                                                class="form-control form-control-sm error-text"
                                                                id="PsRec_Show" disabled>
                                                            <button class="btn btn-outline-secondary btn-sm"
                                                                type="button" onclick="search_User(2)">
                                                                <i class="bi bi-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <label class="form-label mb-0"
                                                            style="min-width: 120px;">รวมนน.แตกต่าง</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            id="dWAll_Show" name="dWAll_Show" disabled>กก.
                                                        <input type="hidden" name="diffWeightAll" id="diffWeightAll">
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <label class="form-label mb-0"
                                                            style="min-width: 120px;">ผู้ทำรายการ</label>
                                                        <div class="input-group flex-grow-1">
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="idUser" name="idUser"
                                                                value="{{ session('idPs') }}">
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="User_Show" value="{{ session('name') }}" disabled>
                                                            <button class="btn btn-outline-secondary btn-sm"
                                                                type="button" onclick="search_User(3)">
                                                                <i class="bi bi-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="input-group flex-grow-1">
                                                            <input type="hidden" class="form-control form-control-sm"
                                                                id="idCompb" name="idCompb">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="checkLayout pt-2">
                                                <div class="checkbox-group d-flex align-items-center gap-2">
                                                    <input type="checkbox" id="labCheck" name="labCheck"
                                                        value="1">
                                                    <label class="checkbox-label mb-0" for="labCheck">
                                                        รับทดสอบใน Lab ออก
                                                    </label>
                                                    <input type="text" id="Point" name="Point"
                                                        style="width: 60px;" class="form-control" value="">
                                                    <span>หน. / 1 ตัวอย่าง</span> <span id="lab"
                                                        class="error-text">(กรุณาเลือกการส่งเมล็ดตัวอย่างเข้า Lab
                                                        ***)</span>
                                                </div>

                                                <div class="checkbox-group">
                                                    <input type="checkbox" id="farmerCheck" name="farmerCheck"
                                                        value="1">
                                                    <label class="checkbox-label"
                                                        for="farmerCheck">ส่งเมล็ดโดยเกษตรกร</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="modal-content">
                                        <div class="seed-inspection-table pt-3 pb-5">
                                            <div class="header-title text-center">
                                                <h2>ระบบคะแนนจาการตรวจรับเมล็ด</h2>
                                                <h3>คะแนนหมายถึงเกิดเหตุการณ์นี้เยอะ (คะแนนเต็ม 3)</h3>
                                            </div>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th class="col-ลำดับ">ลำดับ</th>
                                                        <th class="col-เหตุการณ์">เหตุการณ์ที่ตรวจรับเมล็ด</th>
                                                        <th class="col-คะแนน">ดีไร่</th>
                                                        <th class="col-คะแนน">ทีคลัง</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="highlight-blue">
                                                        <td>1</td>
                                                        <td>เมล็ดหัก, เมล็ดบิด, งอ, เมล็ดขุ่น</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>เมล็ดจากผลเน่า, ต้นตาย, ขึ้นรา, งอกก่อน...</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>หิน, กรวด, เศษเยื่ออื่นๆ ปน</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>เมล็ดดิบ, เมล็ดอ่อน</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>เมล็ดแตก, เมล็ดปากอ้า</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr class="highlight-red">
                                                        <td>6</td>
                                                        <td>มีเมล็ดเป็นรา</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr class="highlight-red">
                                                        <td>7</td>
                                                        <td>มีเมล็ดของสายพันธุ์อื่นปน</td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="grade-selector-wrapper">
                                            <fieldset>
                                                <legend>เกรดเมล็ด</legend>

                                                <label>
                                                    <input type="radio" name="GradUser" value="A"> A
                                                </label>
                                                <label>
                                                    <input type="radio" name="GradUser" value="B"> B
                                                </label>
                                                <label>
                                                    <input type="radio" name="GradUser" value="C"> C
                                                </label>
                                                <label>
                                                    <input type="radio" name="GradUser" value="F"> F
                                                </label>
                                            </fieldset>
                                        </div>
                                        <span id="radioGrad" class="error-text text-center">(กรุณาเลือกเกรดเมล็ด)</span>
                                    </div> --}}

                                    {{-- <div class="grade-selector-wrapper">
                                        <fieldset>
                                            <legend>เกรดเมล็ด</legend>

                                            <label>
                                                <input type="radio" name="seed_grade" value="A" checked> A
                                            </label>

                                            <label>
                                                <input type="radio" name="seed_grade" value="B"> B
                                            </label>

                                            <label>
                                                <input type="radio" name="seed_grade" value="C"> C
                                            </label>
                                        </fieldset>
                                    </div> --}}

                                    <div class="grade-selector-wrapper">
                                        <fieldset>
                                            <legend>เกรดเมล็ด</legend>

                                            <label>
                                                <input type="radio" name="GradUser" value="A"> A
                                            </label>
                                            <label>
                                                <input type="radio" name="GradUser" value="B"> B
                                            </label>
                                            <label>
                                                <input type="radio" name="GradUser" value="C"> C
                                            </label>
                                            <label>
                                                <input type="radio" name="GradUser" value="F"> F
                                            </label>
                                        </fieldset>
                                    </div>
                                    <span id="radioGrad" class="error-text text-center">(กรุณาเลือกเกรดเมล็ด)</span>
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button id="btnSaveData" type="button" class="btn btnSave">บันทึก</button>
                            <button id="btnCacelSave" type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">ยกเลิก</button>
                        </div>

                    </div>
            </div>
            </form>
        </div>
    </div>
    </div>

     {{-- เลือกเมล็ด --}}
    <div class="modal fade" id="Detail_Qr" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #198754cc, #005923e0);">
                        <i class="bi bi-box-seam" style="font-size: 20px; color: white; margin-right: 10px;"></i>
                        <h4 class="modal-title" style="color: white !important;">รายละเอียดรับเมล็ด</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            style="background-color: white;"></button>
                    </div>
                    <div class="container">
                        <h1>QR Code</h1>
                        
                        <div class="qr-box">
                            <img src="" alt="QR Code" width="250">
                        </div>


                        {{-- <button class="btn btn-print" onclick="SeedDetail({{ $id }})">รายละเอียด</button> --}}
                        {{-- <button class="btn btn-close" onclick="window.close()">ปิด</button> --}} --}}
                      
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="SaveNote" method="POST" action="/save-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="inputModalLabel">หมายเหตุเพิ่มเติม</h5>
                        <button type="button" class="btn-close" id="cacelModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="myInput" class="form-label">ต้องการระบุหมายเหตุเพิ่มเติมหรือไม่</label>
                            <input type="text" class="form-control" id="NoteRecBeforeSet" name="NoteRecBeforeSet"
                                placeholder="พิมพ์ข้อความ...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cacelModal2"
                            data-bs-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-primary" id="saveBtnNote">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            const thaiMonths = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            ];
            $("#JrDate").datepicker({
                dateFormat: "dd-mm-yy",
                monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.',
                    'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'
                ],
                changeMonth: true,
                changeYear: true,
                onClose: function(dateText, inst) {
                    if (dateText) {
                        const parts = dateText.split('-');
                        const day = parts[0];
                        const month = thaiMonths[parseInt(parts[1], 10) - 1];
                        const year = parseInt(parts[2], 10) + 543;
                        $(this).val(`${day} ${month} ${year}`);
                    }
                }
            });
            // ตั้งค่าวันปัจจุบันเป็น default
            const today = new Date();
            const day = today.getDate();
            const month = thaiMonths[today.getMonth()];
            const year = today.getFullYear() + 543;
            $("#JrDate").val(`${day} ${month} ${year}`);
        });
    </script>
    <script>
        function formatThaiDate(dateStr) {
            if (!dateStr || dateStr.length !== 8) return ''; // ตรวจสอบว่ารูปแบบถูกต้องหรือไม่
            const year = dateStr.substring(0, 4); // ปี (พ.ศ.)
            const month = dateStr.substring(4, 6); // เดือน
            const day = dateStr.substring(6, 8); // วัน
            return `${day}/${month}/${year}`;
        }

        function SearchEmp(idFm, fullName) {
            // ใส่ค่าใน input
            $('#idFarmer').val(idFm); // ซ่อน ID เกษตรกร
            $('#Nsearch_Emp').val(fullName); // แสดงชื่อเกษตรกร

            // ปิด modal หลังเลือกเสร็จ
            $('#emp_modal').modal('hide');
        }

        function SearchUser(idPs, PsName) {
            if (currentNum == 1) {
                $('#idPsSend').val(idPs);
                // $('#PsSend_Show').val(PsName); //แบบเดิม
                $('#PsSend_Show').val(PsName).removeClass("error-text");
            } else if (currentNum == 2) {
                $('#idPsRec').val(idPs);
                $('#PsRec_Show').val(PsName).removeClass("error-text");
            } else if (currentNum == 3) {
                $('#idUser').val(idPs);
                $('#User_Show').val(PsName);
            }

            $('#User_modal').modal('hide');

            $('#farmerCheck').val('1').removeClass("error-text");
        }


        function SearchCancel() {
            window.location.reload();
        }

        // function SearchData() {
        //     let idFarmer1 = $('#idFarmer').val();
        //     let idSeason = $('#Season').val();

        //     console.log('เกษตรกร:', idFarmer1, 'ฤดูกาล:', idSeason);

        //     ShowSdFr(idFarmer1, idSeason);
        // }

        // ShowSdFr();

        let type = "{{ $type }}";
        // console.log('Type:', type);
        ShowSdFr(null, null, type);

        // function ShowSdFr(idFarmer1 = null, idSeason = null, type) {
        //     console.log(idFarmer1, idSeason, type);


        //     if (type === 'farmer') {
        //         $('#iconShow').attr('src', '{{ asset('img/2780981.png') }}');
        //         $('#textShow').text('รับเมล็ดจากเกษตรกร');
        //         $('#typeShow').val('farmer');
        //     } else if (type === 'pending') {
        //         $('#iconShow').attr('src', '{{ asset('img/2780980.png') }}');
        //         $('#textShow').text('รับเมล็ดจากเกษตรกรก่อนถึงสถานะ');
        //         $('#typeShow').val('pending');
        //     } else if (type === 'receive') {
        //         $('#iconShow').attr('src', '{{ asset('img/clipart3221312.png') }}');
        //         $('#textShow').text('รับเมล็ด');
        //         $('#typeShow').val('receive');
        //     }

        //     // if (type === 'main') {
        //     //     $('#textShow').text('รับเมล็ดจากเกษตรกร');
        //     //     $('#typeShow').val('main');
        //     // } else if (type === 'pre') {
        //     //     $('#textShow').text('รับเมล็ดจากเกษตรกรก่อนถึงสถานะ');
        //     //     $('#typeShow').val('pre');
        //     // }

        //     console.log('ID เกษตรกร:', idFarmer1, 'ID ฤดูกาล:', idSeason, 'Type:', type);

        //     $("#loadingOverlay").show();

        //     // if ($.fn.DataTable.isDataTable('#RequistionTable')) {
        //     //     $('#RequistionTable').DataTable().destroy();
        //     // }

        //     $.ajax({
        //         type: "get",
        //         url: base_url + "/Seed/DB_GetSd",
        //         // url: getAjaxUrl('/GetSdFr/DB_GetSd'),
        //         data: {
        //             idFarmer1: idFarmer1,
        //             idSeason: idSeason,
        //             type: type
        //             // idSeason2: idSeason2,
        //         },
        //         dataType: "json",
        //         success: function(response) {

        //             console.log('ข้อมูล', response);
        //             // return false;

        //             let content = '';
        //             // let get_data = response.GetSdFr; // อันเดิมกก่อนจะเปลี่ยนวิธีกดเปลี่ยนข้อมูล
        //             let get_data = response.data.GetSdFr;
        //             // console.log(get_data.length);

        //             let data_receive = response.data.data_receive;
        //             // console.log(data_receive.length);

        //             if (type === "receive") {
        //                 console.log("หน้า:", type);
        //                 $('#RequistionTableGet').removeClass('d-none');
        //                 $('#RequistionTable').addClass('d-none');
        //                 // // ซ่อนตารางก่อน
        //                 $('#RequistionTableGet').hide();
        //                 setTimeout(() => {
        //                     let num = 1;
        //                     let rows = [];

        //                     const $table = $('#RequistionTableGet');
        //                     const $tbody = $('#DataGetSeeds');

        //                     // สร้าง rows
        //                     data_receive.forEach(element => {
        //                         rows.push(`
        //                                     <tr>
        //                                         <td class="text-center border">${num++}</td> 
        //                                         <td class="text-center align-middle" onclick="GetSeeds(${element.idJob}, ${element.idCompb}, '${element.SeasonCode}')">
        //                                             <div class="d-flex justify-content-center align-items-center">
        //                                                 <img src="{{ asset('img/printing.png') }}" alt="Print" class="icon-size btn-expand" data-id="${element.idIndex}">
        //                                             </div>
        //                                         </td>
        //                                         <td class="border text-center">${element.NumRef ?? '-'}</td>               
        //                                         <td class="border text-center">${element.FmType ?? '-'}</td>             
        //                                         <td class="border text-center">${element.NUM ?? '-'}</td>                
        //                                         <td class="border text-center">${element.SeasonCode ?? '-'}</td>         
        //                                         <td class="border text-center">${element.ZoneName_ ?? '-'}</td>           
        //                                         <td class="border text-center">${element.PsSp ?? '-'}</td>                
        //                                         <td class="border text-center">${element.Grade ?? '-'}</td>               
        //                                         <td class="border text-center">${element.JrDate ?? '-'}</td>            
        //                                         <td class="border text-center">${element.FmName ?? '-'}</td>           
        //                                         <td class="border text-center">${element.PlantName ?? '-'}</td>          
        //                                         <td class="border text-center">${element.PdCode ?? '-'}</td>             
        //                                         <td class="border text-center">${element.StrainCode ?? '-'}</td>          
        //                                         <td class="border text-end">${parseFloat(element.PackKgRai ?? 0).toFixed(2)}</td>    
        //                                         <td class="border text-end">${parseFloat(element.PackKgStore ?? 0).toFixed(2)}</td>   
        //                                         <td class="border text-end">${parseFloat(element.HumidRai ?? 0).toFixed(2)}</td>     
        //                                         <td class="border text-end">${parseFloat(element.HumidStore ?? 0).toFixed(2)}</td>   
        //                                     </tr>`);
        //                     });

        //                     // Destroy DataTable ถ้ามี
        //                     if ($.fn.DataTable.isDataTable($table)) {
        //                         $table.DataTable().clear().destroy();
        //                     }

        //                     // Update content
        //                     $tbody.empty().append(rows.join(''));

        //                     // Initialize DataTable
        //                     $table.DataTable({
        //                         order: [
        //                             [0, 'asc']
        //                         ],
        //                         dom: 'ltip',
        //                         responsive: true,
        //                         deferRender: true,
        //                         autoWidth: false,
        //                         pageLength: 10,
        //                         language: {
        //                             url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"
        //                         },
        //                         initComplete: function() {
        //                             // แสดงตารางหลังจาก DataTable พร้อมแล้ว
        //                             $table.fadeIn(300);
        //                         }
        //                     });

        //                 }, 0);

        //             } else if (type === "farmer" || type === "pending") {
        //                 console.log("หน้า:", type ,get_data);
        //                 $('#RequistionTableGet').addClass('d-none');
        //                 $('#RequistionTable').removeClass('d-none');

        //                 setTimeout(() => {
        //                     let num = 1;
        //                     let rows = [];

        //                     const $table = $('#RequistionTable');
        //                     const $tbody = $('#DataSeeds');

        //                     get_data.forEach(element => {
        //                         rows.push(`
        //                                     <tr>
        //                                         <td class="text-center border">${num++}</td>
        //                                         <td class="text-center align-middle" onclick="GetSeeds(${element.idJob},${element.idCompb},${element.SeasonCode})">
        //                                             <span style="display:none;">${element.idJob}</span>
        //                                             <div class="d-flex justify-content-center align-items-center">
        //                                                 <div class="grow mx-1">
        //                                                     <img src="{{ asset('img/add-folder.png') }}" 
        //                                                         alt="Search Icon" 
        //                                                         class="icon-size btn-expand"
        //                                                         data-id="${element.idIndex}">
        //                                                 </div>
        //                                             </div>
        //                                         </td>
        //                                         <td class="border">${element.JobNo}</td>
        //                                         <td class="border">${formatThaiDate(element.DateReceive_)}</td>
        //                                         <td class="border">${element.StrainCode}</td>
        //                                         <td class="border">${element.PlantName}</td>
        //                                         <td class="border">${element.FmName}</td>
        //                                         <td class="border">${element.ZoneName_}</td>
        //                                         <td class="border">${element.PsName}</td>
        //                                     </tr>`);
            //                     });

        //                     if ($.fn.DataTable.isDataTable($table)) {
        //                         $table.DataTable().clear().destroy();
        //                     }
        //                     $tbody.empty().append(rows.join(''));

        //                     $table.DataTable({
        //                         order: [
        //                             [0, 'asc']
        //                         ],
        //                         dom: 'ltip',
        //                         responsive: true,
        //                         deferRender: true,
        //                         autoWidth: false,
        //                         pageLength: 10,
        //                         language: {
        //                             url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"
        //                         },
        //                         initComplete: function() {
        //                             $table.fadeIn(300);
        //                         }
        //                     });


        //                 }, 0);

        //             }

        //             $('#SearchMaterial').off('keyup').on('keyup', function() {
        //                 dt.search(this.value).draw();
        //             });

        //         },
        //         complete: function() {
        //             $("#loadingOverlay").fadeOut();
        //         }
        //     });
        // }

        function ShowSdFr(idFarmer1 = null, idSeason = null, type = null) {

            if (!type) {
                type = $('#typeShow').val() || "{{ $type }}";
            }

            // console.log(' ShowSdFr called:', idFarmer1, idSeason, type);


            if (type === 'farmer') {
                $('#iconShow').attr('src', '{{ asset('img/2780981.png') }}');
                $('#textShow').text('รับเมล็ดจากเกษตรกร');
                $('#typeShow').val('farmer');
            } else if (type === 'pending') {
                $('#iconShow').attr('src', '{{ asset('img/2780980.png') }}');
                $('#textShow').text('รับเมล็ดจากเกษตรกรก่อนถึงสถานะ');
                $('#typeShow').val('pending');
            } else if (type === 'receive') {
                $('#iconShow').attr('src', '{{ asset('img/clipart3221312.png') }}');
                $('#textShow').text('รับเมล็ด');
                $('#typeShow').val('receive');
            }

            $("#loadingOverlay").show();

            // ⭐ Destroy DataTable ทั้งสองตาราง
            if ($.fn.DataTable.isDataTable('#RequistionTable')) {
                $('#RequistionTable').DataTable().destroy();
                $('#DataSeeds').empty();
            }
            if ($.fn.DataTable.isDataTable('#RequistionTableGet')) {
                $('#RequistionTableGet').DataTable().destroy();
                $('#DataGetSeeds').empty();
            }

            $.ajax({
                type: "GET",
                url: base_url + "/Seed/DB_GetSd",
                data: {
                    idFarmer1: idFarmer1,
                    idSeason: idSeason,
                    type: type,
                    // _: new Date().getTime() // CRITICAL: บังคับไม่ให้ cache
                },
                // cache: false, // CRITICAL: ปิด cache
                dataType: "json",
                success: function(response) {
                    // console.log('ข้อมูล', response);

                    let get_data = response.data.GetSdFr;
                    let data_receive = response.data.data_receive;

                    if (type === "receive") {

                        const $table = $('#RequistionTableGet');
                        const $tbody = $('#DataGetSeeds');

                        $table.hide();
                        $('#RequistionTableGet').removeClass('d-none');

                        let num = 1;
                        let rows = [];
                            // onclick="window.open('/Seed/qr/${element.idIndex}','_blank')">
                            // <td class="text-center align-middle" onclick="SeedDetail(${element.idJobRecPack})">
                            
                            // <td class="text-center align-middle" onclick="window.open('/Seed/qr/${element.idJobRecPack}','_blank')">
                            //     <span style="display:none;">${element.idJob}</span>
                            //     <div class="d-flex justify-content-center align-items-center">
                            //         <div class="grow mx-1">
                            //             <img src="{{ asset('img/printing.png') }}" alt="Search Icon" class="icon-size btn-expand" data-id="${element.idIndex}">
                            //         </div>
                            //     </div> 
                            // </td>    
                            

                        if (data_receive && data_receive.length > 0) {
                            data_receive.forEach(element => {
                            rows.push(`<tr>
                            <td class="text-center border">${num++}</td> 
                            
                            <td class="text-center align-middle" onclick="window.location.href='/Seed/qr/${element.idJobRecPack}'">
                                <span style="display:none;">${element.idJob}</span>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="grow mx-1">
                                        <img src="{{ asset('img/printing.png') }}" alt="Search Icon" class="icon-size btn-expand" data-id="${element.idIndex}">
                                    </div>
                                </div> 
                            </td>
                            <td class="border text-center">${element.NumRef ?? '-'}</td>               
                            <td class="border text-center">${element.FmType ?? '-'}</td>             
                            <td class="border text-center">${element.NUM ?? '-'}</td>                
                            <td class="border text-center">${element.SeasonCode ?? '-'}</td>         
                            <td class="border text-center">${element.ZoneName_ ?? '-'}</td>           
                            <td class="border text-center">${element.PsSp ?? '-'}</td>                
                            <td class="border text-center">${element.Grade ?? '-'}</td>               
                            <td class="border text-center">${element.JrDate ?? '-'}</td>            
                            <td class="border text-center">${element.FmName ?? '-'}</td>           
                            <td class="border text-center">${element.PlantName ?? '-'}</td>          
                            <td class="border text-center">${element.PdCode ?? '-'}</td>             
                            <td class="border text-center">${element.StrainCode ?? '-'}</td>          
                            <td class="border text-end">${parseFloat(element.PackKgRai ?? 0).toFixed(2)}</td>    
                            <td class="border text-end">${parseFloat(element.PackKgStore ?? 0).toFixed(2)}</td>   
                            <td class="border text-end">${parseFloat(element.HumidRai ?? 0).toFixed(2)}</td>     
                            <td class="border text-end">${parseFloat(element.HumidStore ?? 0).toFixed(2)}</td>   
                        </tr>`);
                            });
                        }

                        $tbody.html(rows.join(''));

                        $table.DataTable({
                            destroy: true,
                            order: [
                                [0, 'asc']
                            ],
                            dom: 'ltip',
                            responsive: true,
                            deferRender: true,
                            autoWidth: false,
                            pageLength: 10,
                            language: {
                                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"
                            }
                        });

                        $table.fadeIn(300);

                    } else if (type === "farmer" || type === "pending") {

                        const $table = $('#RequistionTable');
                        const $tbody = $('#DataSeeds');

                        $table.hide();
                        $('#RequistionTable').removeClass('d-none');

                        let num = 1;
                        let rows = [];


                        get_data.forEach((element, index) => {
                            rows.push(`<tr>
                        <td class="text-center border">${num++}</td>
                        <td class="text-center align-middle" onclick="GetSeeds(${element.idJob},${element.idCompb},${element.SeasonCode})">
                            <span style="display:none;">${element.idJob}</span>
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="grow mx-1">
                                    <img src="{{ asset('img/add-folder.png') }}" alt="Search Icon" class="icon-size btn-expand" data-id="${element.idIndex}">
                                </div>
                            </div>
                        </td>
                        <td class="border">${element.JobNo ?? '-'}</td>
                        <td class="border">${element.DateReceive_ ? formatThaiDate(element.DateReceive_) : '-'}</td>
                        <td class="border">${element.StrainCode ?? '-'}</td>
                        <td class="border">${element.PlantName ?? '-'}</td>
                        <td class="border">${element.FmName ?? '-'}</td>
                        <td class="border">${element.ZoneName_ ?? '-'}</td>
                        <td class="border">${element.PsName ?? '-'}</td>
                    </tr>`);
                        });

                        $tbody.html('');

                        $tbody.html(rows.join(''));

                        $table.DataTable({
                            destroy: true,
                            order: [
                                [0, 'asc']
                            ],
                            dom: 'ltip',
                            responsive: true,
                            deferRender: true,
                            autoWidth: false,
                            pageLength: 10,
                            language: {
                                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"
                            }
                        });

                        $table.fadeIn(300);

                    }

                    // Search function
                    $('#SearchMaterial').off('keyup').on('keyup', function() {
                        const currentTable = type === "receive" ? '#RequistionTableGet' :
                            '#RequistionTable';
                        $(currentTable).DataTable().search(this.value).draw();
                    });

                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                },
                complete: function() {
                    $("#loadingOverlay").fadeOut();
                }
            });
        }


        // $('#SearchMaterial').off('keyup').on('keyup', function() {
        //     dt.search(this.value).draw();
        // });

        // return false;

        // let num = 1;
        // data_receive.forEach(element => {
        //     content += `
    //     <tr>
    //         <td class="text-center border">${num++}</td> 
    //         <td class="text-center align-middle" onclick="GetSeeds(${element.idJob}, ${element.idCompb}, '${element.SeasonCode}')">
    //             <div class="d-flex justify-content-center align-items-center">
    //                 <img src="{{ asset('img/printing.png') }}" alt="Print" class="icon-size btn-expand" data-id="${element.idIndex}">
    //             </div>
    //         </td>
    //         <td class="border text-center"><span>${element.NumRef ?? '-'}</span></td>               
    //         <td class="border text-center"><span>${element.FmType ?? '-'}</span></td>             
    //         <td class="border text-center"><span>${element.NUM ?? '-'}</span></td>                
    //         <td class="border text-center"><span>${element.SeasonCode ?? '-'}</span></td>         
    //         <td class="border text-center"><span>${element.ZoneName_ ?? '-'}</span></td>           
    //         <td class="border text-center"><span>${element.PsSp ?? '-'}</span></td>                
    //         <td class="border text-center"><span>${element.Grade ?? '-'}</span></td>               
    //         <td class="border text-center"><span>${element.JrDate ?? '-'}</span></td>            
    //         <td class="border text-center"><span>${element.FmName ?? '-'}</span></td>           
    //         <td class="border text-center"><span>${element.PlantName ?? '-'}</span></td>          
    //         <td class="border text-center"><span>${element.PdCode ?? '-'}</span></td>             
    //         <td class="border text-center"><span>${element.StrainCode ?? '-'}</span></td>          
    //         <td class="border text-end"><span>${parseFloat(element.PackKgRai ?? 0).toFixed(2)}</span></td>    
    //         <td class="border text-end"><span>${parseFloat(element.PackKgStore ?? 0).toFixed(2)}</span></td>   
    //         <td class="border text-end"><span>${parseFloat(element.HumidRai ?? 0).toFixed(2)}</span></td>     
    //         <td class="border text-end"><span>${parseFloat(element.HumidStore ?? 0).toFixed(2)}</span></td>   
    //     </tr>`;
        // });
        // $('#DataGetSeeds').empty().append(content);

        // if ( $.fn.DataTable.isDataTable('#RequistionTableGet') ) {
        //     $('#RequistionTableGet').DataTable().clear().destroy();
        // }
        // $('#DataGetSeeds').empty().append(content);
        // let dt = $('#RequistionTableGet').DataTable({
        //     order: [[0, 'asc']],
        //     dom: 'ltip',
        //     responsive: true,
        //     language: {
        //         url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"
        //     }
        // });


        // let num = 1;
        // get_data.forEach(element => {
        //     content += `
    //     <tr>
    //         <td class="text-center border">${num++}</td>
    //         <td class="text-center align-middle" Onclick="GetSeeds(${element.idJob},${element.idCompb},${element.SeasonCode})">
    //             <span style="display:none;">${element.idJob}</span>
    //             <div class="d-flex justify-content-center align-items-center">
    //                 <div class="grow mx-1">
    //                     <img src="{{ asset('img/add-folder.png') }}" 
    //                         alt="Search Icon" 
    //                         class="icon-size btn-expand"
    //                         data-id="${element.idIndex}">
    //                 </div>
    //             </div>
    //         </td>
    //         <td class="border"><span>${element.JobNo}</span></td>
    //         <td class="border"><span>${formatThaiDate(element.DateReceive_)}</span></td>
    //         <td class="border"><span>${element.StrainCode}</span></td>
    //         <td class="border"><span>${element.PlantName}</span></td>
    //         <td class="border"><span>${element.FmName}</span></td>
    //         <td class="border"><span>${element.ZoneName_}</span></td>
    //         <td class="border"><span>${element.PsName}</span></td>
    //     </tr>`;
        // });
        // $('#DataSeeds').empty().append(content);

        // if ( $.fn.DataTable.isDataTable('#RequistionTable') ) {
        //     $('#RequistionTable').DataTable().clear().destroy();
        // }
        // $('#DataSeeds').empty().append(content);
        // let dt = $('#RequistionTable').DataTable({
        //     order: [[0, 'asc']],
        //     dom: 'ltip',
        //     responsive: true,
        //     language: {
        //         url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"
        //     }
        // });
        //  setTimeout(() => {
        //                     let num = 1;
        //                     let rows = [];

        //                     const $table = $('#RequistionTable');
        //                     const $tbody = $('#DataSeeds');

        //                     get_data.forEach(element => {
        //                         rows.push(`
    //                                     <tr>
    //                                         <td class="text-center border">${num++}</td>
    //                                         <td class="text-center align-middle" onclick="GetSeeds(${element.idJob},${element.idCompb},${element.SeasonCode})">
    //                                             <span style="display:none;">${element.idJob}</span>
    //                                             <div class="d-flex justify-content-center align-items-center">
    //                                                 <div class="grow mx-1">
    //                                                     <img src="{{ asset('img/add-folder.png') }}" 
    //                                                         alt="Search Icon" 
    //                                                         class="icon-size btn-expand"
    //                                                         data-id="${element.idIndex}">
    //                                                 </div>
    //                                             </div>
    //                                         </td>
    //                                         <td class="border">${element.JobNo}</td>
    //                                         <td class="border">${formatThaiDate(element.DateReceive_)}</td>
    //                                         <td class="border">${element.StrainCode}</td>
    //                                         <td class="border">${element.PlantName}</td>
    //                                         <td class="border">${element.FmName}</td>
    //                                         <td class="border">${element.ZoneName_}</td>
    //                                         <td class="border">${element.PsName}</td>
    //                                     </tr>`);
        //                     });

        //                     if ($.fn.DataTable.isDataTable($table)) {
        //                         $table.DataTable().clear().destroy();
        //                     }
        //                     $tbody.empty().append(rows.join(''));

        //                     $table.DataTable({
        //                         order: [
        //                             [0, 'asc']
        //                         ],
        //                         dom: 'ltip',
        //                         responsive: true,
        //                         deferRender: true,
        //                         autoWidth: false,
        //                         pageLength: 10,
        //                         language: {
        //                             url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/th.json"
        //                         },
        //                         initComplete: function() {
        //                             $table.fadeIn(300);
        //                         }
        //                     });


        //                 }, 0);
        //             $('#SearchMaterial').off('keyup').on('keyup', function() {
        //                 dt.search(this.value).draw();
        //             });
        //         },
        //         complete: function() {
        //             $("#loadingOverlay").fadeOut();
        //         }
        //     });
        // }





        // function SearchData() {
        //     let idFarmer1 = $('#idFarmer').val();
        //     let idSeason = $('#Season').val();
        //     // console.log('เกษตรกร:', idFarmer1, 'ฤดูกาล:', idSeason);
        //     ShowSdFr(idFarmer1, idSeason);
        // }
        function SearchData() {
            let idFarmer1 = $('#idFarmer').val();
            let selectedSeason = $('#Season').val();

            $.ajax({
                type: "POST",
                // url: base_url + "/GetSdFr/SelectSeason",
                url: base_url + "/Seed/SelectSeason",
                data: {
                    Season: selectedSeason,
                    _token: '{{ csrf_token() }}'
                },
                dataType: "json",
                success: function() {
                    // console.log('Session updated to:', selectedSeason);
                    ShowSdFr(idFarmer1, selectedSeason);
                }
            });
        }


        let get_data = null;

        function GetSeeds(idJob, idCompb, SeasonCode) {
            // console.log('ID JOB:', idJob,idCompb ,SeasonCode);
            // เปิด modal เลือกเมล็ด
            $('#Item_modal').modal('show');

            $.ajax({
                type: "get",
                url: base_url + "/Seed/DB_GetSeedsByJob",
                data: {
                    idJob: idJob,
                    idCompb: idCompb,
                    SeasonCode: SeasonCode
                },
                dataType: "json",
                success: function(response) {
                    // console.log('ข้อมูลเมล็ด:', response.GetSeedsByJob);
                    // console.log('JrCode:', response);
                    get_data = response.GetSeedsByJob;
                    get_JrCode = response.JrCode;
                    get_GetNumRef = response.GetNumRef;

                    $('#JobNo').val(get_data.JobNo);
                    $('#pd_Code').val(get_data.StrainCode);
                    $('#pd_season').val(get_data.SeasonCode);
                    $('#FarmerName').val(get_data.FmName);

                    $('#ZoneName').val(get_data.ZoneName_);
                    $('#MomPack').val(get_data.MomPack);
                    $('#SeedTypeName').val(get_data.SeedTypeName);
                    $('#idCompb').val(get_data.idCompb);
                    $('#PsName').val(get_data.PsName);
                    $('#idJob').val(get_data.idJob);

                    // let result = parseFloat(get_data.EstimateW).toFixed(2);
                    // $('#EstimateW').val(result);

                    $('#JrCode').val(get_JrCode.DocCode);
                }
            });
        }


        function SeedDetail (idJobRecPack){
            // window.location.href = `/Seed/SeedDetail/${idJobRecPack}`;
            let id  = idJobRecPack;

            $.ajax({
                    type: "get",
                    url: base_url + "/Seed/showQr",
                    data: {
                        idJobRecPack: id
                    },
                    dataType: "json",
                    success: function (response) {
                        // console.log('---',response);
                         $(".qr-box img").attr("src", response);
                        
                        //  window.open(`/Seed/SeedDetail`);
                        // window.location.href = (`/Seed/SeedDetail/${response.idJobRecPack}`);
                     
                    }
            });
                
            $('#Detail_Qr').modal('show');

            //  อีกวิธี เผื่อดึงข้อมูลjson 
            //  $.ajax({
            //         type: "get",
            //         url: base_url + "/Seed/Show_Detail",
            //         data: {
            //             idJobRecPack: idJobRecPack
            //         },
            //         dataType: "json",
            //         success: function (response) {
            //             console.log('---',response);
            //             //  window.open(`/Seed/SeedDetail`);
            //             // window.location.href = (`/Seed/SeedDetail/${response.idJobRecPack}`);
                        
            //         }
            //     });
        }
        


        let table = $('#datatableUser').DataTable({
            dom: 'Bfrtip',
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.1.5/i18n/th.json'
            }
        });

        function search_User(e) {
            currentNum = e;
            $('#User_modal').modal('show');

            $("#loadingOverlay").show();

            $.ajax({
                type: "get",
                url: base_url + "/Seed/getFarmer",
                dataType: "json",
                success: function(response) {
                    let emp = response.getUser;
                    let rows = emp.map(element => {
                        return [
                            `<div class="text-center">
                                    <i class="bi bi-plus-circle" 
                                    style="cursor:pointer; color:green;" 
                                   <button onclick="SearchUser(${element.idPs}, '${element.PsName}')"></button>
                                    </i>
                                </div>`,
                            element.PsName,
                            element.DeptName,
                            element.ComName
                        ];
                    });

                    table.clear().rows.add(rows).draw();
                },
                complete: function() {
                    $("#loadingOverlay").fadeOut();
                }
            });
        }

        function checkLab() {
            if ($('#labCheck').is(':checked')) {
                $('.error-text').hide();
            } else {
                $('.error-text').show();
            }
        }

        $(document).ready(function() {

            $('#lab').hide();
            $('#radioGrad').hide();

            // ซ่อน error labCheck ทันทีเมื่อติ๊ก
            $('#labCheck').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#lab').hide();
                } else {
                    $('#lab').show();
                }
            });

            // ซ่อน error RecPack ตอนแก้ไข
            $("#RecPack").on("input", function() {
                $("#text-er").text("").removeClass("error-text");
            });

            // ซ่อน error GradUser ตอนเลือก radio
            $('input[name="GradUser"]').on('change', function() {
                $('#radioGrad').hide();
            });

            // $('#Season').on('change', function() {
            //     let selectedSeason = $(this).val();

            //     $.ajax({
            //         type: "POST",
            //         url: base_url + "/GetSdFr/SelectSeason",
            //         data: { Season: selectedSeason, _token: '{{ csrf_token() }}' },
            //         dataType: "json",
            //         success: function() {
            //             console.log('Session updated to:', selectedSeason);

            //             // เรียก filter หลัง session อัพเดต
            //             let idFarmer1 = $('#idFarmer').val();
            //             ShowSdFr(idFarmer1, selectedSeason); 
            //         }
            //     });
            // });


            // บันทึก
            $('#btnSaveData').click(function() {
                var formData = new FormData($("#SaveData")[0]);
                // formData.forEach((value, key) => {
                //     console.log(key, value);
                // });

                // return false;

                let dataArr = [];
                let num = parseInt($("#RecPack").val(), 10);

                let JrCode = $('#JrCode').val().slice(2);

                for (let i = 1; i <= num; i++) {
                    let PNcode = `PN${get_data.JobNo}-${i}/${num}${JrCode}`;

                    let textNumRef = $(`#NumRef-${i}`).text(); // เช่น "682/5"
                    let onlyNumRef = 0;
                    if (textNumRef.includes('/')) {
                        onlyNumRef = parseInt(textNumRef.split('/')[1], 10); // เอาเลขหลัง '/' เช่น 5
                    }

                    dataArr.push({
                        index: i,
                        PN: PNcode,
                        farmWeight: $(`#farm-weight-${i}`).val() || 0, //นน.ที่คลัง/กก.
                        farmMoisture: $(`#farm-moisture-${i}`).val() || 0, //ความชื้นที่ไร่%
                        storeWeight: $(`#store-weight-${i}`).val() || 0, //นน.ที่คลัง/กก.
                        storeMoisture: $(`#store-moisture-${i}`).val() || 0, //ความชื้นที่คลัง%
                        diffWeight: $(`#diff-weight-${i}`).val() || 0, // นน แตกต่าง/กก.  --ยังไม่ได้เอาไปใช้
                        diffMoisture: $(`#diff-moisture-${i}`).val() || 0, //ความชื้นแตกต่าง   --ยังไม่ได้เอาไปใช้
                        // NumRef: $(`#NumRef-${i}`).text(), // ดึงค่า Season/NumRef จาก td
                        NumRef: onlyNumRef,
                        grade: $(`#ShowDataItem tr:nth-child(${i}) .GradeShow`).val() || '' // ดึงค่า select
                    });
                }
                // console.log('ข้อมูลทั้งหมดตอน Save:', dataArr);

                formData.append('dataArr', JSON.stringify(dataArr));
                // console.log('FormData:', formData);

                // return false;

                // แสดง confirm ก่อนส่ง
                Swal.fire({
                    title: "ต้องการบันทึกหรือไม่?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "บันทึกเรียบร้อย"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: base_url + "/Seed/SaveData",
                            data: formData,
                            dataType: "json",
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                // console.log('บันทึกข้อมูลสำเร็จ:', response);

                                if (response.status === 422) {
                                    Swal.fire({
                                        title: "กรุณากรอกข้อมูลให้ครบ!",
                                        icon: "error"
                                    });

                                    let allGradeSelected = true;

                                    for (let i = 1; i <= num; i++) {
                                        let gradeVal = $(
                                            `#ShowDataItem tr:nth-child(${i}) .GradeShow`
                                        ).val();

                                        if (!gradeVal) {
                                            allGradeSelected = false;

                                            Swal.fire({
                                                title: "คุณยังไม่ได้เลือกเกรดในตาราง!",
                                                text: `กรุณาเลือกเกรดในแถวที่ ${i}`,
                                                icon: "warning"
                                            });

                                            $(`#ShowDataItem tr:nth-child(${i}) .GradeShow`)
                                                .addClass('error-border');

                                            break;
                                        }
                                    }
                                    if (!allGradeSelected) {
                                        return;
                                    }
                                    $('#ShowDataItem').on('change', '.GradeShow',
                                        function() {
                                            $(this).removeClass('error-border');
                                        });


                                    if (response.errors.idPsSend) {
                                        $("#PsSend_Show").val(response.errors.idPsSend[
                                            0]).addClass("error-text");
                                    } else {
                                        $("#PsSend_Show").removeClass("error-text");
                                    }
                                    if (response.errors.idPsRec) {
                                        $("#PsRec_Show").val(response.errors.idPsRec[0])
                                            .addClass("error-text");
                                    } else {
                                        $("#PsRec_Show").removeClass("error-text");
                                    }
                                    if (response.errors.RecPack) {
                                        $("#text-er").text(response.errors.RecPack[0])
                                            .addClass("error-text");
                                    } else {
                                        $("#text-er").text("").removeClass(
                                            "error-text");
                                    }
                                    if (response.errors.GradUser) {
                                        if ($('input[name="GradUser"]:checked')
                                            .length === 0) {

                                            $('#radioGrad').show();
                                            Swal.fire({
                                                title: "คุณยังไม่ได้เลือกเกรดเมล็ด",
                                                text: "กรุณาเลือกเกรดเมล็ด",
                                                icon: "warning"
                                            });
                                        } else {
                                            $('#radioGrad')
                                                .hide(); // ซ่อน error ถ้าเลือกแล้ว
                                        }
                                    }

                                    if (response.errors.labCheck) {
                                        if ($('#labCheck').is(':checked')) {
                                            $('#lab').hide();
                                        } else {
                                            $('#lab').show();
                                        }

                                        // ถ้าไม่มี error ของ field อื่น ๆ → popup
                                        if (!response.errors.idPsSend && !response
                                            .errors.idPsRec) {
                                            Swal.fire({
                                                title: "คุณยังไม่ได้ส่งเมล็ดตัวอย่างเข้า LAB",
                                                text: "กรุณาเลือกการส่งเมล็ดตัวอย่างเข้า LAB",
                                                icon: "warning"
                                            });
                                        }
                                    }
                                    return;
                                }
                                // ถ้า success
                                // Swal.fire({
                                //     title: "เรียบร้อย",
                                //     icon: "success"
                                // });

                                var typeShow = $('#typeShow').val();

                                // if (typeShow === 'pre') {
                                if (typeShow === 'pending') {
                                    Swal.fire({
                                        title: "เรียบร้อย",
                                        icon: "success"
                                    }).then(() => {
                                        $('#inputModal').modal('show');
                                    });
                                } else {
                                    Swal.fire({
                                        title: "เรียบร้อย",
                                        icon: "success",
                                        confirmButtonText: "ตกลง",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        // draggable: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                }
                                // var typeShow = $('#typeShow').val();
                                // if (typeShow === 'pre') {
                                //     $('#inputModal').modal('show');
                                // }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: "ผิดพลาด!",
                                    text: xhr.responseText,
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });

            //บันทึกหมายเหตุ
            $('#saveBtnNote').click(function() {
                // var formData = new FormData($("#SaveNote")[0]);
                // formData.forEach(function(value, key) {
                //     console.log(key, value);
                // });
                // let idJob = $('#idJob').val();
                var formData = new FormData($("#SaveNote")[0]);
                let idJob = $('#idJob').val();
                formData.append('idJob', idJob);

                $.ajax({
                    type: "POST",
                    url: base_url + "/Seed/UpdateDBNote",
                    data: formData,
                    // data: {
                    //     formData,
                    //     idJob : idJob
                    // },
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response) {
                            // console.log('บันทึกหมายเหตุ', response);
                            Swal.fire({
                                title: "เรียบร้อย",
                                icon: "success",
                                confirmButtonText: "ตกลง",
                                draggable: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }
                        // ,
                        // error: function(xhr, status, error){
                        //     console.log('เกิดข้อผิดพลาด', xhr.responseText);
                        // }
                        ,
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        console.log(xhr.responseText);
                    }
                });

            });


            $('#RefNum').on('change', function() {
                let refNum = $(this).val();
                // console.log('RefNum changed:', refNum);
                $.ajax({
                    type: "get",
                    url: base_url + "/Seed/Get_RefNum",
                    data: {
                        refNum: refNum
                    },
                    dataType: "json",
                    success: function(response) {
                        // console.log('มีข้อมูล:', response);
                        let count = response.count;
                        if (count >= 1) {
                            // Swal.fire("รหัสอ้างอิงนี้ มีการรับไปแล้ว!");
                            Swal.fire({
                                title: "รหัสอ้างอิงนี้ มีการรับไปแล้ว!",
                                text: "กรุณากรอกรหัสอ้างอิงใหม่",
                                icon: "warning",
                                confirmButtonColor: "#198754cc",
                                confirmButtonText: "ตกลง"
                            });
                            $('#RefNum').val('');
                        }
                    }
                });
            });

            const monthNames = [
                "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            ];
            let today = new Date();

            let day = today.getDate();
            let month = monthNames[today.getMonth()];
            let year = today.getFullYear() + 543;

            let formattedDate = `${day} ${month} ${year}`;
            // $("#JrDate").html(`<option value="${formattedDate}">${formattedDate}</option>`);
            $("#JrDate").val(formattedDate);


            $("#RecPack").on("input", function() {
                let val = $(this).val();
                let num = parseInt(val, 10); // แปลงเป็นตัวเลข

                // ถ้ามากกว่า 10 ให้เซ็ตค่าเป็น 10 ทันที
                if (num > 1000) {
                    num = 1000;
                    $(this).val(1000);
                }
                // get_data มาจากการกด GetSeeds
                $("#ShowDataItem").empty();

                let JrCode = $('#JrCode').val().slice(2);

                if (!isNaN(num) && num > 0) {
                    let numRef = get_GetNumRef.NumRef;
                    for (let i = 1; i <= num; i++) {

                        let PNcode = `PN${get_data.JobNo}-${i}/${num}`;
                        let row = `
                                <tr>
                                    <td class="text-center no-select" style="background-color:#f0f2f5;">${i}</td>
                                    <td class="text-center no-select d-none" style="background-color:#f0f2f5;"id="PN-${i}" >PN${get_data.JobNo}-${i}/${num}${JrCode}</td>
                                    <td class="text-center"><input type="number" class="form-control form-control-sm farm-weight" id="farm-weight-${i}" min="0" style="width: 100px;" placeholder="0"></td>
                                    <td class="text-center"><input type="number" class="form-control form-control-sm farm-moisture" id="farm-moisture-${i}" min="0" max="100" step="0.1" style="width: 100px;" placeholder="0.0"></td>
                                    <td class="text-center"><input type="number" class="form-control form-control-sm store-weight" id="store-weight-${i}" min="0" style="width: 100px;" placeholder="0"></td>
                                    <td class="text-center"><input type="number" class="form-control form-control-sm store-moisture" id="store-moisture-${i}" min="0" max="100" step="0.1" style="width: 100px;" placeholder="0.0"></td>
                                    <td class="text-center" style="background-color:#ea9999;"><input type="number" class="form-control form-control-sm diff-weight" id="diff-weight-${i}" style="width: 100px;" value="0" readonly></td>
                                    <td class="text-center" style="background-color:#ea9999;"><input type="number" class="form-control form-control-sm diff-moisture" id="diff-moisture-${i}" style="width: 100px;" value="0" readonly></td>
                                    <td class="text-center">
                                        <select class="GradeShow form-control form-control-sm dropdown-select" style="width: 100px;">
                                            <option value="">--เลือกเกรด--</option>
                                        </select>
                                    </td>
                                   <td class="text-center no-select" style="background-color:#f0f2f5;"id="NumRef-${i}" >${get_GetNumRef.SeasonCode}/${++numRef}</td>
                                </tr>`;
                        $("#ShowDataItem").append(row);
                    }

                    // เติม option ด้วย Ajax 
                    // let $select = $("#ShowDataItem tr:last .GradeShow");
                    let $select = $(".GradeShow");

                    // console.log('🔵 base_url:', base_url);
                    // console.log('🔵 Full URL:', base_url + "/GetSdFr/getGrade");

                    $.ajax({
                        type: "get",
                        url: base_url + "/Seed/getGrade",
                        dataType: "json",
                        success: function(response) {
                            // console.log('เกรด', response.getGrade);

                            let gradeOptions = '<option value="">--เลือกเกรด--</option>';
                            response.getGrade.forEach(grade => {
                                // ควรกำหนด value ด้วย จะได้รู้ว่าเลือกอะไร
                                gradeOptions +=
                                    `<option value="${grade.GradeCode}">${grade.GradeCode}</option>`;
                            });

                            $select.html(gradeOptions); // เติม option

                            // ผูก event change หลังจาก option ถูกสร้างแล้ว
                            $select.on('change', function() {
                                let selected = $(this).val();
                                // console.log('คุณเลือกเกรด:', selected);

                                $('#Grade').val(selected);
                            });
                        }
                        // ,
                        // error: function(xhr) {
                        //     console.error(xhr.responseText);
                        //     $select.html('<option value="">โหลดไม่สำเร็จ</option>');
                        // }
                    });

                    // คำนวณเมื่อกรอกข้อมูล
                    $('.farm-weight, .farm-moisture, .store-weight, .store-moisture').on('input',
                        function() {
                            let row = $(this).closest('tr');
                            let i = row.find('td:first').text();
                            let farmWeight = parseFloat($('#farm-weight-' + i).val()) || 0;
                            let storeWeight = parseFloat($('#store-weight-' + i).val()) || 0;
                            let farmMoisture = parseFloat($('#farm-moisture-' + i).val()) || 0;
                            let storeMoisture = parseFloat($('#store-moisture-' + i).val()) || 0;

                            // //PN
                            // let PNcode = $('#PN-' + i).text(); // ใช้ .text() แทน .val()
                            // // ใส่ลง input ตัวอื่น
                            // $('#PN_code').val(PNcode);

                            let diffWeight = (farmWeight - storeWeight).toFixed(1);
                            let diffMoisture = (farmMoisture - storeMoisture).toFixed(1);

                            $('#diff-weight-' + i).val(diffWeight);
                            $('#diff-moisture-' + i).val(diffMoisture);

                            // คำนวณค่าเฉลี่ยความชื้น
                            let totalFarmMoisture = 0;
                            let totalStoreMoisture = 0;
                            let validRows = 0;

                            for (let j = 1; j <= num; j++) {
                                let currentFarmMoisture = parseFloat($('#farm-moisture-' + j).val()) ||
                                    0;
                                let currentStoreMoisture = parseFloat($('#store-moisture-' + j)
                                    .val()) || 0;
                                if (currentFarmMoisture > 0 || currentStoreMoisture > 0) {
                                    totalFarmMoisture += currentFarmMoisture;
                                    totalStoreMoisture += currentStoreMoisture;
                                    validRows++;
                                }
                            }

                            let avgFarmMoisture = validRows > 0 ? (totalFarmMoisture / validRows)
                                .toFixed(1) : 0;
                            let avgStoreMoisture = validRows > 0 ? (totalStoreMoisture / validRows)
                                .toFixed(1) : 0;

                            // อัปเดตค่าใน input
                            $('#JrHumidRai').val(avgFarmMoisture);
                            $('#JrHumidStore').val(avgStoreMoisture);

                            // คำนวณน้ำหนักรวม
                            let fWAll = 0;
                            let SWAll = 0;
                            let DW_All = 0;
                            for (let j = 1; j <= num; j++) {
                                fWAll += parseFloat($('#farm-weight-' + j).val()) || 0;
                                SWAll += parseFloat($('#store-weight-' + j).val()) || 0;
                                DW_All += parseFloat($('#diff-weight-' + j).val()) || 0;
                            }

                            $('#JrRecRai , #JR_Show').val(fWAll);
                            $('#JrRecStore , #JS_Show').val(SWAll);
                            $('#diffWeightAll , #dWAll_Show').val(DW_All);

                            //PN แสดง PNcode
                            // $('#PN_code').val(PNcode);
                        });
                }
            });

            // ปิดmodalแล้วล้างค่า
            $('.btn-close ,#btnCacelSave').click(function() {
                $('#ShowDataItem').empty();
                $('#RecPack').val('');
                $('#PsSend_Show').val('');
                $('#PsRec_Show').val('');
                $('#RefNum').val('');
                $('#Note').val('');
                $('input[name="GradUser"]').prop('checked', false);
                $('#labCheck').prop('checked', false);
                $('#farmerCheck').prop('checked', false);
                $('#idPsRec').val('');
                $('#idPsSend').val('');
                $('#JrHumidRai').val('');
                $('#JrHumidStore').val('');
                $('#lab').hide();
                $('#radioGrad').hide();
                $("#text-er").text("").removeClass("error-text");
            });

            $('#cacelModal2 ,#cacelModal').click(function() {
                window.location.reload();
            });

            // สร้าง DataTable แค่ครั้งแรก
            let table = $('#datatableEmp').DataTable({
                dom: 'Bfrtip',
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.1.5/i18n/th.json'
                },
                select: {
                    style: 'single'
                }
            });

            $('#search_Emp').click(function(e) {
                e.preventDefault();
                $("#loadingOverlay").show();

                $.ajax({
                    type: "get",
                    url: base_url + "/Seed/getFarmer",
                    dataType: "json",
                    success: function(response) {
                        // console.log('เกษตรกร', response.getFarmer);
                        let emp = response.getFarmer;
                        let rows = emp.map(element => {
                            return [
                                `<div class="text-center">
                                        <i class="bi bi-plus-circle" 
                                            style="cursor:pointer; color:green;" 
                                            onclick="SearchEmp(${element.idFm}, '${element.FullName}')">
                                        </i>
                                    </div>`,
                                element.FullName
                            ];
                        });
                        table.clear().rows.add(rows).draw();
                        $('#emp_modal').modal('show');
                    },
                    complete: function() {
                        $("#loadingOverlay").fadeOut();
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', status, error);
                    }
                });
            });


        });
    </script>
@endsection
