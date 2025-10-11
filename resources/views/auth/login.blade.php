<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Bank Sampah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #234cff 0%, #0ad3ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        
        .card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 50px;
            width: 50%;
            max-width: 250px;
            min-height: 420px;
        }
        
        .tab-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 35px;
        }
        
        .tab-button {
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            font-size: 15px;
        }
        
        .tab-button.active {
            background: linear-gradient(135deg, #234cff 0%, #0ad3ff 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }
        
        .input-field {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }
        
        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .btn-primary {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #234cff 0%, #0ad3ff 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }
        
        .link-text {
            background: linear-gradient(135deg, #234cff 0%, #0ad3ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
        
        .link-text:hover {
            text-decoration: underline;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            color: #334155;
            font-weight: 500;
            font-size: 15px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }

        @media (min-width: 768px) {
            .card {
                max-width: 75vw;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Tab Navigation -->
        <div class="tab-container">
            <button class="tab-button active" id="loginTab">Login</button>
            <button class="tab-button" id="registerTab">Daftar</button>
        </div>

        <!-- Login Form -->
        <div id="loginForm">
            <form method="POST" action="{{ route('auth') }}" enctype="multipart/form-data">
                @csrf  
                <div class="form-group">
                    <label for="email">Masukan Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="input-field" 
                        placeholder="Masukan Email"
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Masukan Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="input-field" 
                        placeholder="Masukan Password"
                        required
                    >
                </div>

                <div class="form-group" style="text-align: left; margin-bottom: 30px;">
                    <a href="#" class="link-text">Lupa password?</a>
                </div>

                <button type="submit" class="btn-primary">Login</button>

                <p style="text-align: center; margin-top: 25px; color: #64748b; font-size: 15px;">
                    Belum punya akun? <a href="{{ route('register') }}" class="link-text">Daftar sekarang</a>
                </p>
            </form>
        </div>
    </div>

    <script>
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        
        registerTab.addEventListener('click', function() {
            window.location.href = '{{ route("register") }}';
        });
        
        loginTab.addEventListener('click', function() {
            loginTab.classList.add('active');
            registerTab.classList.remove('active');
        });
    </script>
</body>
</html>