<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; }
        .logo { color: #d4af37; font-size: 28px; font-weight: bold; text-align: center; }
        .title { font-size: 22px; text-align: center; }
        .btn { display: block; width: 200px; margin: 20px auto; padding: 15px 30px; background: #d4af37; color: #fff; text-align: center; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; }
        .btn:hover { background: #b8960f; }
        .note { color: red; text-align: center; font-size: 14px; }
        .footer { text-align: center; color: #999; font-size: 12px; margin-top: 20px; }
        .url-box { background: #f8f9fa; padding: 10px; border-radius: 5px; word-break: break-all; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">Rizk</div>
        <h2 class="title">إعادة تعيين كلمة المرور</h2>
        <p>مرحباً،</p>
        <p>لقد تلقينا طلباً لإعادة تعيين كلمة المرور الخاصة بحسابك.</p>
        
        <a href="{{ $actionUrl }}" class="btn">🔑 إعادة تعيين كلمة المرور</a>
        
        <p class="note">⏳ هذا الرابط صالح لمدة دقيقتين فقط!</p>
        
        <div class="url-box">
            <small>إذا لم يعمل الزر، انسخ هذا الرابط:</small><br>
            <a href="{{ $actionUrl }}">{{ $actionUrl }}</a>
        </div>
        
        <p style="font-size: 14px; color: #666;">إذا لم تطلب هذا، يمكنك تجاهل البريد.</p>
        <div class="footer">© 2026 Rizk</div>
    </div>
</body>
</html>
