<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi OTP</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .greeting {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 20px;
        }
        .otp-container {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 2px solid #22c55e;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
        }
        .otp-label {
            font-size: 16px;
            color: #374151;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            color: #16a34a;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }
        .instructions {
            color: #6b7280;
            font-size: 14px;
            margin: 20px 0;
            line-height: 1.5;
        }
        .warning {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning-text {
            color: #92400e;
            font-size: 14px;
            margin: 0;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            color: #6b7280;
            font-size: 12px;
            margin: 0;
        }
        .company-name {
            color: #16a34a;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌱 Budhi Soya Foods</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                @if($userName)
                    Halo {{ $userName }},
                @else
                    Halo,
                @endif
            </div>
            
            <p>Terima kasih telah mendaftar di <span class="company-name">Budhi Soya Foods</span>!</p>
            <p>Untuk melengkapi proses verifikasi akun Anda, silakan gunakan kode OTP berikut:</p>
            
            <div class="otp-container">
                <div class="otp-label">Kode Verifikasi OTP Anda:</div>
                <div class="otp-code">{{ $otpCode }}</div>
            </div>
            
            <div class="instructions">
                <strong>Petunjuk:</strong><br>
                1. Masukkan kode OTP di atas pada halaman verifikasi<br>
                2. Kode ini berlaku selama <strong>10 menit</strong><br>
                3. Jangan bagikan kode ini kepada siapa pun
            </div>
            
            <div class="warning">
                <p class="warning-text">
                    <strong>⚠️ Penting:</strong> Jika Anda tidak merasa mendaftar di Budhi Soya Foods, 
                    abaikan email ini atau hubungi customer service kami.
                </p>
            </div>
        </div>
        
        <div class="footer">
            <p class="footer-text">
                Email ini dikirim secara otomatis, mohon tidak membalas email ini.<br>
                © 2024 <span class="company-name">Budhi Soya Foods</span>. Semua hak dilindungi.
            </p>
        </div>
    </div>
</body>
</html>