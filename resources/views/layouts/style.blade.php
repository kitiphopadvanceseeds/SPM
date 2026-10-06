<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('SPM ระบบคลังเมล็ด') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">


    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

    <style>
        * {
            font-family: 'Prompt', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ทำทั้งเว็บ (ทุก element) เป็นขาวดำ รวมถึงรูปภาพ */
            /* * {
            -webkit-filter: grayscale(100%);
            filter: grayscale(100%);
            } */


        /* body {
            background: #2d2d7f !important;
            color: #fff;
        } */

        /* Main Header */
        .main-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            background: transparent;
            transition: all 0.4s ease;
            /* padding: 10px 0; */
            background: linear-gradient(135deg, #198754cc, #005923e0);
            color: #fff;
        }

        .main-header.fixed-nav {
            /* background: #fff; */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Navbar Brand */
        .navbar-brand img {
            max-width: 50px;
        }

        /* Menu Links */
        #mainMenu li a {
            color: #fff;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
            padding: 8px 12px;
            position: relative;
            transition: color 0.3s ease;
        }

        .fixed-nav #mainMenu li a {
            color: #333;
        }

        /* Hover Underline */
        #mainMenu li a::before {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background: #fff;
            transition: width 0.3s ease;
        }

        #mainMenu li a:hover::before {
            width: 100%;
        }

        /* Mobile Toggle */
        .navbar-toggler {
            border: none;
            outline: none;
            color: #fff;
            font-size: 28px;
        }

        /* .fixed-nav .navbar-toggler {
            color: #333;
        } */

        /* Mobile Menu Background */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: #00000017;
            }

            #mainMenu li {
                margin: 5px 0;
            }

            #mainMenu li a {
                color: #fff;
                font-size: 16px;
            }
        }

        .container {
            display: block !important;
        }

        @media (max-width: 480px) {
            .align-items-center {
                align-items: start !important;
            }
        }
    </style>
    @yield('style')
</head>

<body>
    <header class="main-header">
        {{-- <div class="container"> --}}
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg px-0">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    {{-- <img src="{{ asset('img/Green_Seeds.png') }}" alt="รับเมล็ดจาก JOB" style="height:40px;"> --}}
                    <img src="{{ asset('img/clipart3221312.png') }}"
                        style="height:40px; filter: brightness(0) invert(1);">
                    <span class="ms-2 text-white">SPM ระบบคลังเมล็ด</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">
                    <i class="bi bi-list"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="mainMenu">
                    <ul class="navbar-nav align-items-center">
                        {{-- อันเดิมแบบลิ้งไปอีกหน้า --}}
                        {{-- <li class="nav-item">
                            <a href="{{ url('/GetSdFr') }}" class="nav-link active">รับเมล็ดจากเกษตรกร</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/GetSdFrPre') }}"
                                class="nav-link">รับเมล็ดจากเกษตรกรก่อนถึงสถานะที่กำหนด</a>
                        </li> --}}

                        {{-- อันใหม่แบบกดละเปลี่ยนข้อมูลในตาราง --}}
                        {{-- <li class="nav-item">
                            <a href="#" onclick="loadTable('main')" class="nav-link active">รับเมล็ดจากเกษตรกร</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" onclick="loadTable('pre')" class="nav-link">รับเมล็ดจากเกษตรกรก่อนถึงสถานะ</a>
                        </li> --}}


                        
                        {{-- <ul class="navbar-nav align-items-center">
                            <li class="nav-item">
                                <a href="javascript:void(0)" onclick="ShowSdFr(null, null, 'main')" class="nav-link">รับเมล็ดจากเกษตรกร</a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0)" onclick="ShowSdFr(null, null, 'pre')" class="nav-link">รับเมล็ดจากเกษตรกรก่อนถึงสถานะ</a>
                            </li>
                        </ul> --}}

                        {{-- <ul class="navbar-nav align-items-center">
                            <li class="nav-item">
                                <a href="{{ url('/GetSdFr/1') }}" onclick="ShowSdFr(null, null, 'main')" class="nav-link">รับเมล็ดจากเกษตรกร</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/GetSdFr/2') }}" onclick="ShowSdFr(null, null, 'pre')" class="nav-link">รับเมล็ดจากเกษตรกรก่อนถึงสถานะ</a>
                            
                            </li>
                        </ul> --}}
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item">
                                <a href="{{ url('/Seed/receive') }}" class="nav-link">ข้อมูลการรับเมล็ด</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/Seed/farmer') }}" class="nav-link">รับเมล็ดจากเกษตรกร</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/Seed/pending') }}" class="nav-link">รับเมล็ดจากเกษตรกรก่อนถึงสถานะ</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/audit-log') }}" class="nav-link {{ request()->is('audit-log*') ? 'active' : '' }}">Audit Log</a>
                            </li>
                        </ul>
                      
                        {{-- <ul class="navbar-nav align-items-center">
                            <li class="nav-item">
                                <a href="{{ url('/Seed/receive') }}" class="nav-link">รับเมล็ด</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/seed/farmer') }}" class="nav-link">รับเมล็ดจากเกษตรกร</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/seed/pending') }}" class="nav-link">รับเมล็ดจากเกษตรกรก่อนถึงสถานะ</a>
                            </li>
                        </ul> --}}

                        {{-- <li class="nav-item"><a href="#service" class="nav-link">Services</a></li>
                        <li class="nav-item"><a href="#project" class="nav-link">Projects</a></li>
                        <li class="nav-item"><a href="#team" class="nav-link">Team</a></li>
                        <li class="nav-item"><a href="#testimony" class="nav-link">Testimonials</a></li> --}}

                        <a href="{{ url('/comp') }}" class="nav-item nav-link btn btn-success text-left-custom"
                            style="color: white !important; display: flex; align-items: center; background-color: #20d3a8;">
                            <i class="bi bi-building pe-2 ps-2" style="color: white"></i>
                            {{ session('CompName'). ' : ' . session('BrnName') ?: session('groupName') ?: 'ไม่ได้เลือกบริษัท' }}
                        </a>

                        {{-- ทดสอบฤดู --}}
                        {{-- <a href="{{ url('/comp') }}" class="nav-item nav-link btn btn-success text-left-custom"
                            style="color: white !important; display: flex; align-items: center; background-color: #20d3a8;">
                            <i class="bi bi-building pe-2 ps-2" style="color: white"></i>
                            {{ session('Season') ?: session('SeasonName') ?: 'ไม่ได้เลือกฤดู' }}
                        </a> --}}
                        
                        {{-- <pre>
                          {{ print_r(session()->all()) }}
                        </pre> --}}


                        <!-- รูปโปรไฟล์ + ชื่อ -->
                        <li class="nav-item dropdown ms-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{-- <img src="http://203.151.27.229/spm/images/pPs/{{ session()->get('idPs') }}.jpg"
                                    alt="โปรไฟล์" class="rounded-circle me-2"
                                    style="width: 40px; height: 40px; object-fit: cover;"> --}}
                                <img src="{{ url('/image-proxy/' . session()->get('idPs')) }}" 
                                    alt="โปรไฟล์" 
                                    class="rounded-circle me-2" 
                                    style="width: 40px; height: 40px; object-fit: cover;">
                                    
                                <span class="">สวัสดี: {{ Auth::user()->fullname }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userMenu" style="border-radius: 12px; min-width: 180px;">
                                <li>
                                    <a class="dropdown-item py-2 text-danger fw-semibold d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#dualLogoutModal">
                                        <i class="bi bi-box-arrow-right me-2 fs-5"></i> ออกจากระบบ
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>

            </nav>
        </div>
    </header>

    <!-- โหลด -->
    <div id="loadingOverlay"
        style="
            display:none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.7);
            z-index: 9999;
            text-align: center;
            font-size: 20px;
            color: #333;">
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
            <div class="spinner-border text-primary" role="status">
            </div>
        </div>
    </div>

    <div id="app" style="padding-top:80px;">
    {{-- <div id="app"> --}}
        <main class="px-3 pb-3">
            @yield('content')
        </main>
    </div>

    <!-- โหลด jQuery ก่อน -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- โหลด DataTables หลัง jQuery -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- โหลด Bootstrap JS (ต้องมี Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- DataTables JS -->
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script> --}}

    <!-- jQuery  -->
    {{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> --}}

    <script>
        // var url = "{{ url('/') }}";
        // var secure_url = "{{ secure_url('/') }}";
        // var base_url = (document.domain === "127.0.0.1" || document.domain === "localhost") ? url : secure_url;
        var base_url = "{{ config('app.url') }}";
        // หรือ
        var base_url = window.location.origin;
    </script>
    <script>
        // Sticky Header
        window.addEventListener('scroll', function() {
            document.querySelector('.main-header').classList.toggle('fixed-nav', window.scrollY > 50);
        });
    </script>
    <!-- Dual Logout Modal -->
    <div class="modal fade" id="dualLogoutModal" tabindex="-1" aria-labelledby="dualLogoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #fee2e2; color: #ef4444;">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold text-dark mb-0" id="dualLogoutModalLabel">ยืนยันการออกจากระบบ</h5>
                            <small class="text-muted" style="font-size: 12px;">กรุณาเลือกรูปแบบการออกจากระบบที่ต้องการ</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="d-flex flex-column gap-3">
                        <!-- Option 1: Local Logout -->
                        <form action="{{ route('logout') }}" method="POST" class="w-100 m-0">
                            @csrf
                            <input type="hidden" name="type" value="local">
                            <button type="submit" class="w-100 text-start p-3 border rounded-3 bg-white d-flex align-items-center justify-content-between shadow-sm" style="cursor: pointer; border-color: #e2e8f0; transition: all 0.2s ease;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background-color: #f1f5f9; color: #475569;">
                                        <i class="bi bi-box-arrow-right fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: 14px;">ออกจากระบบเฉพาะแอปนี้ (Local Logout)</div>
                                        <div class="text-muted" style="font-size: 12px;">ออกจากระบบเฉพาะโปรแกรมนี้ คุณยังคงล็อกอินในระบบอื่นของบริษัทอยู่</div>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-muted ms-2"></i>
                            </button>
                        </form>

                        <!-- Option 2: Global SSO Logout -->
                        <form action="{{ route('logout') }}" method="POST" class="w-100 m-0">
                            @csrf
                            <input type="hidden" name="type" value="global">
                            <button type="submit" class="w-100 text-start p-3 border rounded-3 d-flex align-items-center justify-content-between shadow-sm" style="cursor: pointer; border-color: #fecdd3; background-color: #fff5f5; transition: all 0.2s ease;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; background-color: #fee2e2; color: #dc2626;">
                                        <i class="bi bi-power fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-danger" style="font-size: 14px;">ออกจากระบบกลางทั้งหมด (Global SSO)</div>
                                        <div class="text-muted" style="font-size: 12px;">ออกจากระบบ Central Auth ทุกโปรแกรมในเครือจะถูกออกจากระบบพร้อมกัน</div>
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-danger ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top px-4 py-2.5 justify-content-end">
                    <button type="button" class="btn btn-secondary btn-sm px-3 rounded-pill" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </div>
    </div>

    @yield('script')

</body>

</html>
