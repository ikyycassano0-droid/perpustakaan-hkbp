<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | ModernAdmin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    
    <style>
        body {
            background: linear-gradient(135deg, #0b111e 0%, #111827 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .auth-card {
            background: #151c2c;
            border: 1px solid #1f2937;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        .auth-header h3 { color: #fff; font-weight: 700; margin-bottom: 5px; }
        .auth-header p { color: #94a3b8; font-size: 14px; margin-bottom: 30px; }
        .form-group label { color: #94a3b8; font-size: 13px; font-weight: 500; }
        .form-control {
            background: #111827 !important;
            border: 1px solid #1f2937 !important;
            color: #fff !important;
            border-radius: 10px;
            padding: 12px 15px;
            margin-top: 5px;
        }
        .btn-primary {
            background: #3b82f6;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s;
        }
        .btn-primary:hover { background: #2563eb; transform: translateY(-2px); }
        .text-danger { font-size: 12px; margin-top: 5px; display: block; }
        .auth-footer { text-align: center; margin-top: 25px; font-size: 14px; color: #94a3b8; }
        .auth-footer a { color: #3b82f6; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="auth-header">
            <h3>Welcome Back</h3>
            <p>Please enter your credentials to login.</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label>NIM / Username</label>
                <input type="text" name="nim" class="form-control" value="{{ old('nim') }}" placeholder="Enter your NIM" required autofocus>
                @error('nim') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Sign In</button>
        </form>
    </div>

</body>
</html>