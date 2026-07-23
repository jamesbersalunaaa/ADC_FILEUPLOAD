<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADC File Upload Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #111827, #1f2937, #101810);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 22px;
            padding: 35px 30px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
        }

        .logo-box {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo-box img {
            width: 230px;
            max-width: 100%;
        }

        .login-title {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-title h2 {
            color: #1f2937;
            font-size: 24px;
            margin-bottom: 6px;
        }

        .login-title p {
            color: #6b7280;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
        }

        .form-group input {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            outline: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #8aff5c;
            box-shadow: 0 0 0 3px rgba(138, 255, 92, 0.25);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #8aff5c;
            color: #111827;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 8px;
        }

        .login-btn:hover {
            background: #73e84a;
            transform: translateY(-1px);
        }

        .footer-text {
            text-align: center;
            margin-top: 22px;
            font-size: 12px;
            color: #6b7280;
        }

        .error-message {
            background:#fee2e2;
            color:#b91c1c;
            padding:12px;
            border-radius:10px;
            margin-bottom:15px;
            text-align:center;
            font-size:14px;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 28px 22px;
            }

            .logo-box img {
                width: 190px;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">

        <div class="logo-box">
            <img src="{{ asset('images/ADC Final Logo PNG.png') }}" alt="ADC General Merchandise Logo">
        </div>

        <div class="login-title">
            <h2>File Upload System</h2>
            <p>Login to encode and upload files</p>
        </div>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="login-btn">
                Login
            </button>
        </form>

        <div class="footer-text">
            ADC General Merchandise Inc. © 2026
        </div>
    </div>

</body>
</html>