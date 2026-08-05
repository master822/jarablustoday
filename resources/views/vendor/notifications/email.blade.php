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
        .button-container {
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background: #d4af37;
            color: #ffffff !important;
            padding: 16px 50px;
            border-radius: 10px;
            text-decoration: none !important;
            font-weight: bold;
            font-size: 18px;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            transition: all 0.3s ease;
        }
        .button:hover {
            background: #b8960f;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }
        .button:active {
            transform: translateY(0);
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
            border: 1px solid #e9ecef;
        }
        .url {
            color: #d4af37;
            text-decoration: none;
            font-size: 14px;
        }
        .line {
            border: none;
            border-top: 1px solid #e9ecef;
            margin: 30px 0;
        }
        .instruction {
            color: #64748b;
            font-size: 14px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="logo">✨ Rizk</div>
            
            <h2 class="title">إعادة تعيين كلمة المرور</h2>
            
            <p class="message">
                مرحباً،<br>
                لقد تلقينا طلباً لإعادة تعيين كلمة المرور الخاصة بحسابك في منصة <strong>Rizk</strong>.
            </p>
            
            <div class="button-container">
                <a href="{{ $actionUrl }}" class="button" target="_blank" rel="noopener noreferrer">
                    🔑 إعادة تعيين كلمة المرور
                </a>
            </div>
            
            <p class="expiry-note">
                ⚠️ هذا الرابط صالح لمدة {{ config('auth.passwords.users.expire', 60) }} دقيقة فقط.
            </p>
            
            <hr class="line">
            
            <p class="instruction">إذا لم يعمل الزر، انسخ هذا الرابط وألصقه في المتصفح:</p>
            
            <div class="url-container">
                <a href="{{ $actionUrl }}" class="url" target="_blank" rel="noopener noreferrer">
                    {{ $actionUrl }}
                </a>
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
