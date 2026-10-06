{{-- @extends('layouts.style')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
            </div>
        </div>
    </div>
@endsection --}}



@extends('layouts.style')
@section('style')
    <style>
        /* body {
                    background: url("{{ asset('img/sojaernte-soja-ernten.jpg') }}") no-repeat center center fixed;
                    background-size: cover;
                } */

        body {
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.866), rgba(255, 255, 255, 0.413)),
                url("{{ asset('img/sojaernte-soja-ernten.jpg') }}") no-repeat center center fixed;
            background-size: cover;
        }

        .Bg {
            background: linear-gradient(135deg, #198754cc, #005923e0);
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* จัดกึ่งกลางแนวตั้ง */
            align-items: center;
            /* จัดกึ่งกลางแนวนอน */
            height: 350px;
            /* กำหนดความสูงที่นี่เลย */
            text-align: center;
            padding: 1rem;
            /* เว้นระยะขอบด้านในเล็กน้อย */
        }

        .text-bg {
            color: white;
            font-size: 25px;
        }


        .hoverC {
            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        }

        .hoverC:hover {
            transform: scale(1.02) !important;
        }

        @media (max-width: 576px) {
            .Bg {
                height: 300px !important;
            }
        }

        @media (width: 844px) and (height: 390px) {
            .Bg {
                height: 250px !important;
            }

            .boxTop {
                padding-top: 3vw !important;
            }
        }
    </style>
@endsection

@section('content')
    <div class="boxTop" style="padding-top: 5vw;">
        <div class="row g-4 mx-0 justify-content-center">

            {{-- <div class="col-12 col-md-6 col-lg-5 hoverC">
                <a href="{{ url('/GetSdFr') }}" class="text-decoration-none text-reset">
                    <div class="rounded-3 shadow text-info text-center Bg" style="height: 350px;">
                        <img src="{{ asset('img/2780981.png') }}" style="height:60%; filter: brightness(0) invert(1);">
                    
                        <span class="d-block p-2 text-bg">รับเมล็ดจากเกษตรกร</span>
                    </div>
                </a>
            </div>
            <div class="col-12 col-md-6 col-lg-5 hoverC">
                <a href="{{ url('/GetSdFrPre') }}" class="text-decoration-none text-reset">
                    <div class="rounded-3 shadow text-secondary text-center Bg" style="height: 350px;">
                        <img src="{{ asset('img/2780980.png') }}" style="height:55%; filter: brightness(0) invert(1);">
                        <span class="d-block p-2 text-bg">
                            รับเมล็ดจากเกษตรกรก่อนถึงสถานะที่กำหนด
                        </span>
                    </div>
                </a>
            </div> --}}

             <div class="col-12 col-md-6 col-lg-5 hoverC">
                <a href="{{ url('/Seed/receive') }}" class="nav-link">
                    <div class="rounded-3 shadow text-info text-center Bg" style="height: 350px;">
                        <img src="{{ asset('img/clipart3221312.png') }}" style="height:60%; filter: brightness(0) invert(1);">

                        <span class="d-block p-2 text-bg">ข้อมูลการรับเมล็ด</span>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-5 hoverC">
                <a href="{{ url('/Seed/farmer') }}" class="nav-link">
                    <div class="rounded-3 shadow text-info text-center Bg" style="height: 350px;">
                        <img src="{{ asset('img/2780981.png') }}" style="height:60%; filter: brightness(0) invert(1);">

                        <span class="d-block p-2 text-bg">รับเมล็ดจากเกษตรกร</span>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-5 hoverC">
                 <a href="{{ url('/Seed/pending') }}" class="nav-link">
                    <div class="rounded-3 shadow text-secondary text-center Bg" style="height: 350px;">
                        <img src="{{ asset('img/2780980.png') }}" style="height:55%; filter: brightness(0) invert(1);">
                        <span class="d-block p-2 text-bg">
                            รับเมล็ดจากเกษตรกรก่อนถึงสถานะที่กำหนด
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        
    </script>
@endsection
