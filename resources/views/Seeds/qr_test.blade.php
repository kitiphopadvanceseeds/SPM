<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Sarabun', sans-serif;
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

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
            background: linear-gradient(135deg, #1fa265cc, #0e9544e0);
            color: white;
        }

        .btn-print:hover {
            background: #158952cc;
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

        .btn-copy:hover {
            background: #5568d3 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-copy:active {
            transform: translateY(0);
        }

        .btn-copy:hover {
            background: #5967a5 !important;
        }

        .btn-copy:active {
            background: #667eea !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>QR Code</h1>
        
        <div class="qr-box">
            <img src="{{ $qrCodeString }}" alt="QR Code" width="250">
        </div>
        <!-- แสดง URL / ลิงก์ให้คัดลอก -->
        <div style="margin: 20px 0;">
            <div style="display: flex; gap: 0; border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: white;">
                <input type="text" id="qrLink" value="{{ url('/Seed/SeedDetail/' . $id) }}" readonly 
                    style="flex: 1; padding: 12px 15px; border: none; font-size: 14px; color: #333; background: white; outline: none;">
                <button class="btn btn-copy" id="copyBtn" onclick="copyLink()" 
                        style="padding: 12px 25px; background: #667eea; color: white; border: none; cursor: pointer; font-weight: 600; white-space: nowrap; transition: all 0.3s ease; border-left: 2px solid #e0e0e0;">
                    คัดลอก
                </button>
            </div>
            <small id="copyStatus" style="display: block; margin-top: 8px; color: #28a745; font-weight: 600; opacity: 0; transition: opacity 0.3s;"></small>
        </div>

        <button class="btn btn-print" onclick="SeedDetail({{ $id }})">รายละเอียด</button>
        <button class="btn btn-close" onclick="window.location.href='/Seed/receive'">ปิด</button>

    </div>
</body>

<script>
        function SeedDetail ( $id){
             window.location.href = `/Seed/SeedDetail/${$id}`;
        }

        function copyLink() {
            const input = document.getElementById('qrLink');
            const btn = document.getElementById('copyBtn');
            const status = document.getElementById('copyStatus');
            
            input.select();
            document.execCommand('copy');
            
            // // แสดงข้อความสำเร็จ
            // status.textContent = 'คัดลอกลิงก์แล้ว!';
            // status.style.opacity = '1';
            
            // // เปลี่ยนปุ่มชั่วคราว
            // btn.style.background = '#28a745';
            // btn.textContent = 'คัดลอกแล้ว';
            
            // setTimeout(() => {
            //     btn.style.background = '#667eea';
            //     btn.textContent = 'คัดลอก';
            //     status.style.opacity = '0';
            // }, 2000);
        }
        
</script>
</html>