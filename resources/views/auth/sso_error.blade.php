<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งเตือนการยืนยันตัวตน - SPM ระบบคลังเมล็ด</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Google Font Prompt -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Prompt', sans-serif;
            box-sizing: border-box;
        }
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }
        .error-card {
            border: none;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            max-width: 500px;
            width: 100%;
            padding: 40px 30px;
            text-align: center;
        }
        .btn-custom-success {
            background: linear-gradient(135deg, #198754, #005923);
            border: none;
            color: #ffffff;
            transition: all 0.3s ease;
        }
        .btn-custom-success:hover {
            background: linear-gradient(135deg, #02c469, #005923);
            color: #ffffff;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="mb-4">
            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px;">
                <i class="bi bi-shield-x fs-1"></i>
            </div>
        </div>

        <h4 class="fw-bold text-dark mb-2">{{ $title ?? 'การยืนยันตัวตนล้มเหลว' }}</h4>
        <p class="text-muted mb-4" style="font-size: 14px; line-height: 1.6;">
            {{ $message ?? 'ไม่สามารถยืนยันตัวตนกับระบบ Central Auth ได้ กรุณาลองใหม่อีกครั้ง' }}
        </p>

        <div class="d-grid gap-2">
            <a href="{{ url('/login') }}" class="btn btn-custom-success py-2.5 rounded-pill fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-arrow-repeat fs-5"></i> ลองเข้าสู่ระบบใหม่อีกครั้ง
            </a>
            <a href="https://auth.advanceseeds.com" target="_blank" class="btn btn-outline-secondary py-2 rounded-pill" style="font-size: 14px;">
                <i class="bi bi-box-arrow-up-right me-1"></i> ไปยังระบบ Central Auth
            </a>
        </div>
    </div>
</body>
</html>
