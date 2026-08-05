<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إعادة تعيين كلمة المرور - Rizk</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background: #ffffff;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .logo {
            color: #d4af37;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            color: #1a1a2e;
            margin-bottom: 15px;
        }
        .message {
            color: #475569;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            background: #d4af37;
            color: #ffffff !important;
            padding: 14px 40px;
            border-radius: 10px;
            text-decoration: none !important;
            font-weight: bold;
            font-size: 16px;
            margin: 10px 0;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background: #b8960f;
        }
        .footer {
            margin-top: 30px;
            color: #94a3b8;
            font-size: 12px;
        }
        .expiry-note {
            color: #ef4444;
            font-size: 14px;
            margin-top: 15px;
        }
        .url-container {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            word-break: break-all;
        }
        .url {
            color: #d4af37;
            text-decoration: none;
        }
        .line {
            border: none;
            border-top: 1px solid #e9ecef;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">Rizk</div>
            
            <h2 class="title">إعادة تعيين كلمة المرور</h2>
            
            <p class="message">
                مرحباً،<br>
                لقد تلقينا طلباً لإعادة تعيين كلمة المرور الخاصة بحسابك في منصة <strong>Rizk</strong>.
                اضغط على الزر أدناه لإعادة تعيين كلمة المرور.
            </p>
            
            <a href="{{ $actionUrl }}" class="button">
                🔑 إعادة تعيين كلمة المرور
            </a>
            
            <p class="expiry-note">
                ⚠️ هذا الرابط صالح لمدة {{ $expires ?? 'دقيقتين' }} فقط.
            </p>
            
            <hr class="line">
            
            <div class="url-container">
                <small style="color: #64748b;">إذا لم يعمل الزر، انسخ هذا الرابط وألصقه في المتصفح:</small><br>
                <a href="{{ $actionUrl }}" class="url">{{ $actionUrl }}</a>
            </div>
            
            <p style="font-size: 14px; color: #94a3b8; margin-top: 20px;">
                إذا لم تطلب إعادة تعيين كلمة المرور، يمكنك تجاهل هذا البريد الإلكتروني.
            </p>
            
            <div class="footer">
                © 2026 Rizk - جميع الحقوق محفوظة
            </div>
        </div>
    </div>
</body>
</html>
