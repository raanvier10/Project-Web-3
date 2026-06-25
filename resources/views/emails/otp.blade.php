<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Anda</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { background-color: #ffffff; padding: 30px; border-radius: 8px; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        h2 { color: #333333; }
        .otp-box { background-color: #f9f9f9; border: 1px dashed #ccc; padding: 15px; text-align: center; font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #D63384; margin: 20px 0; border-radius: 5px; }
        p { color: #555555; line-height: 1.6; }
        .footer { margin-top: 30px; font-size: 12px; color: #999999; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Verifikasi Akun Anda</h2>
        <p>Halo,</p>
        <p>Terima kasih telah mendaftar. Untuk mengaktifkan akun Anda, silakan masukkan kode OTP (One-Time Password) berikut pada halaman verifikasi:</p>
        
        <div class="otp-box">
            {{ $otpCode }}
        </div>
        
        <p>Kode ini hanya berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun untuk alasan keamanan.</p>
        <p>Terima kasih,<br>Tim Kami</p>

        <div class="footer">
            Jika Anda tidak meminta kode ini, abaikan saja email ini.
        </div>
    </div>
</body>
</html>
