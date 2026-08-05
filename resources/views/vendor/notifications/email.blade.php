<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 40px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .logo { color: #d4af37; font-size: 32px; font-weight: bold; text-align: center; }
        .title { font-size: 24px; text-align: center; color: #1a1a2e; }
        .btn { display: inline-block; padding: 15px 40px; margin: 20px 0; background: #d4af37; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 18px; border: none; cursor: pointer; }
        .btn:hover { background: #b8960f; }
        .btn-container { text-align: center; }
        .note { color: #ef4444; text-align: center; font-size: 14px; font-weight: bold; }
        .url-box { background: #f8fafc; padding: 15px; border-radius: 8px; word-break: break-all; margin: 20px 0; border: 1px solid #e9ecef; }
        .url-box a { color: #d4af37; text-decoration: none; }
        .footer { text-align: center; color: #94a3b8; font-size: 12px; margin-top: 20px; }
        .message { color: #475569; line-height: 1.7; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">Rizk</div>
        <h2 class="title">إعادة تعيين كلمة المرور</h2>
        <p class="message">مرحباً،</p>
        <p class="message">لقد تلقينا طلباً لإعادة تعيين كلمة المرور الخاصة بحسابك في منصة Rizk.</p>
        
        <div class="btn-container">
            <a href="{{ $actionUrl }}" class="btn" style="color:#ffffff !important;">🔑 إعادة تعيين كلمة المرور</a>
        </div>
        
        <p class="note">⚠️ هذا الرابط صالح لمدة دقيقة واحدة فقط!</p>
        
        <div class="url-box">
            <small style="color:#64748b;">إذا لم يعمل الزر، انسخ هذا الرابط:</small><br>
            <a href="{{ $actionUrl }}">{{ $actionUrl }}</a>
        </div>
        
        <p style="font-size:14px; color:#94a3b8;">إذا لم تطلب هذا، يمكنك تجاهل البريد.</p>
        <div class="footer">© 2026 Rizk - جميع الحقوق محفوظة</div>
    </div>
</body>
</html>
