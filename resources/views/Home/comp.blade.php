@extends('layouts.comp_style')
@section('style')
    <style>
        @media (min-width: 992px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm {
                max-width: 100%;
            }
        }

        .btn-link.company-link {

            padding: 12px 15px;
            color: #333;
        }

        .btn-link.company-link:hover {
            background: linear-gradient(135deg, #198754cc, #005923e0);
            color: white;
        }

        .btn-link {
            color: #198754cc !important;
        }

        .w-100 {
            white;
            width: 100% !important;
        }

        .text-primary {
            color: #198754cc !important;
        }

        .t-center {
            margin-bottom: 0rem;
            width: 30%;
            justify-content: center;
            display: flex;
            align-items: center;
            color: #198754cc !important;
            font-size: 18px;
        }

        @media (max-width: 480px) {
           body{
            font-size: 14px;
           }
        }

        .company-item:hover,
        .btn-link:hover {
            background: linear-gradient(135deg, #198754cc, #005923e0);
            color: white !important;
        }


        .accordion-button.no-arrow::after {
            display: none;  /* ซ่อนลูกศรเฉพาะ class นี้ */
        }

        .accordion-button.no-arrow {
            background-color: transparent !important; /* ไม่มีสีพื้นหลัง */
            color: inherit;
        }

    </style>
@endsection

@section('content')
    <!-- Modal เลือกบริษัท -->
    <div class="modal fade" id="CompModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" style="font-weight: 700; color: #198754cc;" id="exampleModalScrollableTitle">
                        เลือกบริษัท</h2>
                </div>
                {{-- @php
                    $thaiYear = date('Y') + 543;
                    $startYear = $thaiYear - 20; // ย้อนหลัง 5 ปี
                    // $endYear = $thaiYear + 2; // ล่วงหน้า 2 ปี
                    $months = [
                        1 => 'มกราคม',
                        2 => 'กุมภาพันธ์',
                        3 => 'มีนาคม',
                        4 => 'เมษายน',
                        5 => 'พฤษภาคม',
                        6 => 'มิถุนายน',
                        7 => 'กรกฎาคม',
                        8 => 'สิงหาคม',
                        9 => 'กันยายน',
                        10 => 'ตุลาคม',
                        11 => 'พฤศจิกายน',
                        12 => 'ธันวาคม',
                    ];
                @endphp
                <div class="p-3" style="display: flex;">
                    <p class="t-center">ฤดูกาลที่ผลิต</p>
                    <select id="yearTrip" name="yearTrip" class="form-control form-control-sm">
                        @for ($y = $thaiYear; $y >= $startYear; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div> --}}

                <div class="p-3" style="display: flex;">
                    <p class="t-center">ฤดูกาลที่ผลิต</p>
                    <select id="Season" name="Season" class="form-control form-control-sm">
                        @foreach ($Season as $item)
                            <option value="{{ $item->idSeasonPd }}" {{ $item->SeasonCode ? 'selected' : '' }}>
                                 {{ $item->SeasonCode }} : {{ $item->SeasonName }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- <div class="modal-body" style="padding-top: 5px;">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <button class="accordion-button fs-4 border text-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-sg" aria-expanded="true" aria-controls="collapse-sg">
                            Seeds Group
                        </button>

                        <div id="collapse-sg" class="accordion-collapse collapse show ">
                            <div id="list-comp" class="accordion-body pe-0 pt-0 ">

                                <div id='main-accordion' class="accordion-item">
                                    <h2 class="accordion-header">

                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="modal-body" style="padding-top: 5px;">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <button class="accordion-button fs-4 border text-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-sg" aria-expanded="true" aria-controls="collapse-sg">
                             GR Group
                        </button>

                        <div id="collapse-sg" class="accordion-collapse collapse show ">
                            <div id="main-accordion" class="accordion-body pe-0 pt-0 ">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection


@section('script')
    <script>
        //กดข้างนอกจะไม่ปิดModal
        const modalElement = document.getElementById('CompModal');
        const modalInstance = new bootstrap.Modal(modalElement, {
            backdrop: 'static', // ป้องกันการปิดเมื่อคลิกด้านนอก
        });
        modalInstance.show();

        $(document).ready(function() {
            // แสดง Modal เลือกบริษัทเมื่อหน้าโหลด
            $('#CompModal').modal('show');
            $('#confirmCompany').click(function() {
                const selectedCompany = $('#company').val();

                if (!selectedCompany) {
                    alert('กรุณาเลือกบริษัทก่อน!');
                } else {
                    alert('คุณเลือกบริษัทหมายเลข: ' + selectedCompany);

                    $('#CompModal').modal('hide');
                }
            });

            $.ajax({
                type: "get",
                url: base_url + "/comp/CompeName",
                dataType: "json",
                success: function(response) {
                    let companies = response.CompeName;
                    // console.log(companies);
                    
                    // จัดกลุ่มตาม idComp (บริษัท)
                    let groupedCompanies = {};
                    companies.forEach(item => {
                        if (!groupedCompanies[item.idComp]) {
                            groupedCompanies[item.idComp] = {
                                CompName: item.CompName,
                                Branches: []
                            };
                        }
                        if (item.BrnName) {
                            // groupedCompanies[item.idComp].Branches.push(item.BrnName);
                             groupedCompanies[item.idComp].Branches.push({
                                idProvince: item.idProvince,
                                BrnName: item.BrnName
                            });
                        }
                    });

                    // สร้างโครง accordion แบบเดิม
                    let mainAccordion = $('#main-accordion');
                    let htmlContent = '';

                    Object.keys(groupedCompanies).forEach((idComp, index) => {
                        let comp = groupedCompanies[idComp];

                        //         <div class="accordion-button fs-5 border border-top-0 text-primary 
                        //             ${comp.Branches.length === 0 ? 'collapsed cursor-default' : (index !== 0 ? 'collapsed' : '')}" 
                        //             type="button" 
                        //             ${comp.Branches.length > 0 
                        //                 ? `data-bs-toggle="collapse" data-bs-target="#collapse-${idComp}" aria-expanded="${index === 0 ? 'true' : 'false'}"` 
                        //                 : ''} 
                        //             aria-controls="collapse-${idComp}">
                        //             <i class="bi bi-building me-2"></i> ${comp.CompName}
                        //         </div>
                        htmlContent += `
                            <div class="accordion-item">
                                <div class="accordion-button fs-5 border border-top-0 text-primary 
                                    ${comp.Branches.length === 0 ? 'no-arrow cursor-default' : ''}" 
                                    type="button" 
                                    ${comp.Branches.length > 0 
                                        ? `data-bs-toggle="collapse" data-bs-target="#collapse-${idComp}" aria-expanded="true"` : ''} 
                                    aria-controls="collapse-${idComp}">
                                    <i class="bi bi-building me-2"></i> ${comp.CompName}
                                </div>

                                ${comp.Branches.length > 0 ? `
                                <div id="collapse-${idComp}" 
                                    class="accordion-collapse  collapse show ${index === 0 ? 'show' : ''}"
                                    style="padding-left: 30px !important;"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body p-0">
                                       ${comp.Branches.map(branch => `
                                            <div class="company-item border">
                                                <button class="btn btn-link company-select w-100 text-start text-decoration-none d-flex align-items-center"
                                                        style="font-size: 1.2rem;"        
                                                        data-id="${idComp}" 
                                                        data-name="${comp.CompName}"
                                                        data-branch="${branch.idProvince}" 
                                                        data-branch-name="${branch.BrnName}">
                                                    <i class="bi bi-caret-right-fill" style="color: #07c152e0;"></i>
                                                    <i class="bi bi-building-gear me-2 text-secondary"></i>
                                                    ${branch.BrnName}
                                                </button>
                                            </div>`).join('')}
                                    </div>
                                </div>` : ''} 
                            </div>`;
                    });
                 
                    mainAccordion.empty().append(htmlContent);

                    // event เมื่อกดเลือก
                  $('.company-select').on('click', function() {
                        let idComp = $(this).data('id');
                        let compName = $(this).data('name');   
                        let idProvince = $(this).data('branch');  
                        let branchName = $(this).data('branch-name');  
                        let Season = $('#Season').val();

                        // console.log("เลือกบริษัท:", idComp, compName, "สาขา:", idProvince, branchName, "Season:", Season);
                        // return false;
                        
                        $.get(getAjaxUrl('selectComp'), 
                        { idComp, Season ,compName ,idProvince ,branchName }).done(() => window.location.href = "/home") .fail(xhr => console.error(xhr.responseText));
                    });
                }
            });


        });

        // $(document).ready(function() {
        //     // แสดง Modal เลือกบริษัทเมื่อหน้าโหลด
        //     $('#CompModal').modal('show');
        //     $('#confirmCompany').click(function() {
        //         const selectedCompany = $('#company').val();

        //         if (!selectedCompany) {
        //             alert('กรุณาเลือกบริษัทก่อน!');
        //         } else {
        //             alert('คุณเลือกบริษัทหมายเลข: ' + selectedCompany);

        //             $('#CompModal').modal('hide');
        //         }
        //     });

        //     $.ajax({
        //         type: "get",
        //         url: base_url + "/comp/CompeName",
        //         dataType: "json",
        //         success: function(response) {
        //             let companies = response.CompeName;

        //             // Group companies by parentid
        //             let groupedCompanies = {};
        //             companies.forEach(company => {
        //                 if (!groupedCompanies[company.parentid]) {
        //                     groupedCompanies[company.parentid] = [];
        //                 }
        //                 groupedCompanies[company.parentid].push(company);
        //             });

        //             let mainAccordion = $('#main-accordion');
        //             let htmlContent = '';
        //             let data = {
        //                 CompName: [{
        //                         group: "AV Group"
        //                     },
        //                     {
        //                         group: "FL Group"
        //                     },
        //                     {
        //                         group: "GR Group"
        //                     }
        //                 ]
        //             };
        //             const groupMapping = data.CompName.reduce((a, item, index) => {
        //                 a[index + 1] = item.group;
        //                 return a;
        //             }, {});

        //             Object.keys(groupedCompanies).forEach((parentId, index) => {
        //                 htmlContent += `
    //                     <div class="accordion-button fs-5 border border-top-0 text-primary ${index !== 0 ? 'collapsed' : ''}" 
    //                         type="button" 
    //                         data-bs-toggle="collapse"
    //                         data-bs-target="#collapse-${parentId}"
    //                         aria-expanded="${index === 0 ? 'true' : 'false'}"
    //                         aria-controls="collapse-${parentId}">
    //                         <i class="bi bi-building me-2"></i> ${groupMapping[parentId] || parentId}
    //                     </div>

    //                     <div id="collapse-${parentId}" 
    //                         class="accordion-collapse collapse ${index === 0 ? 'show' : ''}"
    //                         style="padding-left: 30px !important;"
    //                         data-bs-parent="#accordionExample">
    //                         <div class="accordion-body p-0">
    //                             ${groupedCompanies[parentId].map(company => `
        //                                             <div class="company-item border">
        //                                                 <button class="btn btn-link company-select w-100 text-start text-decoration-none d-flex align-items-center" 
        //                                                         data-id="${company.idComp}">
        //                                                     <i class="bi bi-building-gear me-2 text-secondary"></i>
        //                                                     ${company.CompName}
        //                                                 </button>
        //                                             </div>`).join('')}
    //                         </div>
    //                     </div>`;
        //             });

        //             mainAccordion.empty().append(htmlContent);

        //             $('.company-select').on('click', function() {
        //                 let idComp = $(this).data('id');
        //                 // console.log("เลือกบริษัท:", idComp);

        //                 let Season = $('#Season').val();
        //                 // console.log('ฤดู',Season);

        //                 // console.log(base_url);

        //                 // return false;

        //                 $.ajax({
        //                     type: "get",
        //                     // url: base_url + "/selectComp",
        //                     // url: "{{ secure_url('selectComp') }}", 

        //                     url: getAjaxUrl('selectComp'),

        //                     data: {
        //                         idComp: idComp,
        //                         Season: Season
        //                     },
        //                     success: function(res) {
        //                         // console.log("เลือกบริษัทสำเร็จ", res);
        //                         window.location.href = "/home";
        //                     },
        //                     error: function(xhr) {
        //                         console.error(xhr.responseText);
        //                     }
        //                 });
        //             });
        //         }
        //     });
        // });
    </script>
@endsection
