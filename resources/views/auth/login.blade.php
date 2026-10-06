@extends('layouts.app')

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', 'Arial', sans-serif;
        height: 100vh;
        background: linear-gradient(135deg, #198754cc, #005923e0);
        /* background: linear-gradient(135deg, #60fbb4cc, #005923); */
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .main-container {
        background: white;
        border-radius: 25px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 100%;
        max-width: 1000px;
        height: 600px;
        display: flex;
        position: relative;
    }

    .decorative-circles {
        position: absolute;
        top: -50px;
        left: -50px;
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, #00ffb3, #005923);
        border-radius: 50%;
        opacity: 0.8;
        z-index: 1;
        display: none !important;
    }

    .login-section {
        flex: 1;
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        z-index: 2;
        top: 25px;
    }

    .login-header {
        margin-bottom: 25px;
    }

    .login-title {
        font-size: 36px;
        font-weight: 700;
        color: #33a877;
        margin-bottom: 8px;
        justify-content: center;
        display: flex;
    }

    .login-subtitle {
        color: #6B7280;
        font-size: 16px;
        font-weight: 400;
    }

    .form-container {
        width: 100%;
    }

    .input-group,
    .input-wrapper,
    .form-input,
    .login-btn {
        width: 100%;
        display: block;
    }

    .input-group {
        position: relative;
        margin-bottom: 20px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 18px;
        color: #9CA3AF;
        font-size: 16px;
        z-index: 1;
    }

    .form-input {
        width: 100%;
        padding: 16px 16px 16px 50px;
        border: 2px solid #F3F4F6;
        border-radius: 12px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: #F9FAFB;
        color: #374151;
    }

    .form-input::placeholder {
        color: #9CA3AF;
        font-weight: 400;
    }

    .form-input:focus {
        outline: none;
        border-color: #33ac7a;
        ;
        background: white;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    .form-input:focus+.input-icon {
        color: #7C3AED;
    }

    .login-btn {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #00ffb3, #005923);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 30px 0;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(124, 58, 237, 0.4);
    }

    .login-btn:active {
        transform: translateY(0);
    }

    .divider {
        text-align: center;
        margin: 25px 0;
        position: relative;
        color: #6B7280;
        font-size: 14px;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #E5E7EB;
        z-index: 0;
    }

    .divider span {
        background: white;
        padding: 0 20px;
        position: relative;
        z-index: 1;
    }

    .social-login {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .social-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #E5E7EB;
        border-radius: 10px;
        background: white;
        text-decoration: none;
        color: #374151;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .social-btn:hover {
        border-color: #D1D5DB;
        background: #F9FAFB;
        transform: translateY(-1px);
    }

    .social-btn img,
    .social-btn i {
        margin-right: 12px;
        font-size: 18px;
    }

    .google-btn {
        color: #374151;
    }

    .facebook-btn {
        color: #1877F2;
    }

    .image-section {
        width: 50%;
        height: 100%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-section img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    @media (max-width: 480px) {
        .image-section {
            display: none;
        }

        .login-title {
            padding-top: 4px !important;
            font-size: 18px !important;
        }

        .logo-green {
            display: none !important;
        }

        .decorative-circles {
            display: none !important;
        }
    }

    /* ครอบคลุมมือถือแนวนอนเกือบทุกรุ่น */
    @media only screen and (max-width: 932px) and (orientation: landscape) {
        .main-container {
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            height: 350px;
            display: flex;
            position: relative;
        }

        .logo-green {
            display: none !important;
        }

        .login-title{
            font-size: 18px;
        }

        .decorative-circles{
            display: none !important;
        }

        .login-section{
            top: 25px;
        }
    }

    .character-figure {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 180px;
    }

    .character-head {
        width: 50px;
        height: 50px;
        background: #FDB5A6;
        border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
    }

    .character-hair {
        width: 60px;
        height: 35px;
        background: #8B4513;
        border-radius: 50px 50px 0 0;
        position: absolute;
        top: 15px;
        left: 50%;
        transform: translateX(-50%);
    }

    .character-body {
        width: 70px;
        height: 90px;
        background: #87CEEB;
        border-radius: 15px 15px 0 0;
        position: absolute;
        top: 65px;
        left: 50%;
        transform: translateX(-50%);
    }

    .character-tablet {
        width: 40px;
        height: 30px;
        background: #4A5568;
        border-radius: 3px;
        position: absolute;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
    }

    .floating-icon {
        position: absolute;
        top: 40px;
        right: 40px;
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        animation: float 3s ease-in-out infinite;
    }

    .floating-icon i {
        color: #FCD34D;
        font-size: 24px;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .author-info {
        position: absolute;
        bottom: 30px;
        left: 30px;
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.9);
        padding: 12px 16px;
        border-radius: 50px;
        backdrop-filter: blur(10px);
    }

    .author-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #7C3AED;
        margin-right: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }

    .author-details h4 {
        font-size: 14px;
        font-weight: 600;
        color: #1F2937;
        margin: 0;
    }

    .author-details p {
        font-size: 12px;
        color: #6B7280;
        margin: 0;
    }

    .contact-info {
        position: absolute;
        bottom: 30px;
        right: 30px;
        background: rgba(255, 255, 255, 0.9);
        padding: 8px 16px;
        border-radius: 20px;
        backdrop-filter: blur(10px);
        font-size: 12px;
        color: #6B7280;
    }

    @media (max-width: 768px) {
        .main-container {
            flex-direction: column;
            height: auto;
            max-width: 400px;
        }

        .image-section {
            min-height: 300px;
            order: -1;
        }

        .login-section {
            padding: 40px 30px;
        }

        .author-info,
        .contact-info {
            display: none;
        }
    }

    .logo-green {
        filter: brightness(0) saturate(100%) invert(34%) sepia(98%) saturate(570%) hue-rotate(97deg) brightness(93%) contrast(90%);
    }
</style>

@section('content')
    <div class="main-container">
        <div class="decorative-circles"></div>

        <div class="login-section">
            {{-- <div class="login-header">
                <i class="bi bi-person-circle d-block d-sm-none text-center" style="font-size: 55px; color: #339667;"></i>
                <h1 class="login-title">SPM ระบบคลังเมล็ด</h1>
            </div> --}}

            <div class="login-header text-center">
                <i class="bi bi-person-circle d-block d-sm-none" style="font-size: 65px; color: #339667;"></i>
                <div class="d-flex justify-content-center my-2">
                    <img src="{{ asset('img/clipart3221312.png') }}" style="height:80px; object-fit:contain;" alt="Logo"
                        class="logo-green">
                </div>
                <h1 class="login-title">
                    SPM ระบบคลังเมล็ด
                </h1>
            </div>

            <div class="form-container">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group">
                        <div class="input-wrapper">
                            <input id="UN" type="text" class="form-input @error('UN') is-invalid @enderror"
                                name="UN" value="{{ old('UN') }}" placeholder="Username" required autocomplete="UN"
                                autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-wrapper">
                            <input id="password" type="password" class="form-input" @error('password') is-invalid @enderror
                                name="password" placeholder="Password" required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="login-btn">เข้าสู่ระบบ</button>
                    {{-- <button type="submit" class="btn btn-primary w-75 py-2 mb-3">
                        เข้าสู่ระบบ
                    </button> --}}
                </form>
            </div>
        </div>

        <div class="image-section">
            <img src="{{ asset('img/Seeds.png') }}" alt="Seeds" class="img-fluid">
        </div>
    </div>
@endsection
