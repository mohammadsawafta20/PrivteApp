<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - دلفري للتوصيل</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                        url('https://ar.pngtree.com/freebackground/fashion-takeaway-order-service-psd-layering_1126020.html');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 400px;
            padding: 30px;
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        h2 {
            color: #6a3093;
            margin-bottom: 25px;
            font-weight: 700;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6a3093;
        }

        .input-group input, .input-group select {
            width: 100%;
            padding: 12px 15px 12px 40px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #f9f9f9;
        }

        .input-group input:focus, .input-group select:focus {
            border-color: #6a3093;
            outline: none;
            box-shadow: 0 0 0 3px rgba(106, 48, 147, 0.2);
        }

        .btn-login {
            background: linear-gradient(to right, #6a3093, #a044ff);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(to right, #5a2a7d, #8a3ce0);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 48, 147, 0.4);
        }

        .forgot-pass {
            display: block;
            margin-top: 15px;
            color: #6a3093;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-pass:hover {
            text-decoration: underline;
        }

        .error {
            color: #e74c3c;
            background-color: #fde8e8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 14px;
            border-left: 4px solid #e74c3c;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 20px;
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="https://cdn-icons-png.freepik.com/256/15300/15300698.png?ga=GA1.1.1293284205.1746954550&semt=ais_hybrid" alt="دلفري للتوصيل" class="logo">
        <h2>تسجيل الدخول</h2>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="text" name="phone" placeholder="رقم الهاتف" value="{{ old('phone') }}" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="كلمة المرور" required>
            </div>

            <div class="input-group">
                <i class="fas fa-user-tag"></i>
                <select name="role" required>
                    <option value="admin">أدمن</option>
                    <option value="vendor">متجر</option>
                    <option value="driver">سائق</option>
                </select>
            </div>

            <button type="submit" class="btn-login">دخول</button>

            <a href="#" class="forgot-pass">نسيت كلمة المرور؟</a>
        </form>

        <p class="footer-text">راحتك بتهمنا - دلفري لخدمات التوصيل السريع</p>
    </div>
</body>
</html>
