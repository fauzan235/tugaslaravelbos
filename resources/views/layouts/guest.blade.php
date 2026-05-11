<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login — Sistem Manajemen UKS SMKN 1 Purwokerto">
    <title>Login — UKS Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #0f3460 70%, #e94560 100%);
            background-size: 400% 400%;
            animation: gradientMove 12s ease infinite;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .login-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 48px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            animation: fadeUp 0.6s ease;
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .login-header .icon {
            font-size: 3rem;
            margin-bottom: 8px;
        }
        .login-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        .login-header p {
            font-size: 0.85rem;
            color: #64748b;
            margin-top: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            color: #1a1a2e;
        }
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.15);
        }
        .form-error {
            color: #e94560;
            font-size: 0.78rem;
            margin-top: 4px;
        }
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Inter', sans-serif;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(102,126,234,0.4);
        }
        .login-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.75rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <div class="icon">🏥</div>
            <h1>UKS Digital</h1>
            <p>SMKN 1 Purwokerto</p>
        </div>

        @if($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.85rem; border: 1px solid #fecaca;">
                ❌ {{ $errors->first() }}
            </div>
        @endif

        @yield('content')

        <div class="login-footer">
            © {{ date('Y') }} UKS Digital — SMKN 1 Purwokerto
        </div>
    </div>
</body>
</html>
