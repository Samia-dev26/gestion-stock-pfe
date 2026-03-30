<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - StockPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f4f7fe 0%, #eef2f7 100%);
            padding: 20px;
            margin: 0;
            overflow: hidden;
        }
        
        .login-card {
            max-width: 420px;
            width: 100%;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 50px 40px;
            animation: animate__animated animate__zoomIn 0.8s ease-out;
            position: relative;
            z-index: 10;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 24px;
        }
        
        .logo h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
        }
        
        .logo span {
            color: #3b82f6;
        }
        
        .title {
            text-align: center;
            font-size: 1.6rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 32px;
        }
        
        .form-floating {
            margin-bottom: 1.5rem;
        }
        
        .form-floating .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            height: 56px;
            padding: 1rem 1rem 0.5rem;
            font-weight: 500;
            background: #f8fafc;
        }
        
        .form-floating .form-control:focus {
            border-color: #3b82f6;
            background: white;
            box-shadow: 0 0 0 0.25rem rgba(59,130,246,0.1);
        }
        
        .form-floating label {
            padding-left: 1rem;
            color: #64748b;
            font-weight: 500;
        }
        
        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            border: none;
            border-radius: 25px;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(59,130,246,0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(59,130,246,0.4);
        }
        
        .register-link {
            text-align: center;
            margin-top: 24px;
            font-weight: 500;
        }
        
        .register-link a {
            color: #3b82f6;
            text-decoration: none;
        }
        
        @media (max-width: 480px) {
            .login-card {
                margin: 20px;
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <h2>Stock<span>Pro</span></h2>
        </div>
        
        <h3 class="title">Connexion</h3>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="form-floating">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                <label for="email">Email</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-floating">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                <label for="password">Mot de passe</label>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-login mb-3">
                Se connecter
            </button>
            
            @if (Route::has('password.request'))
                <div class="text-end">
                    <a href="{{ route('password.request') }}" class="text-muted text-decoration-none">Mot de passe oublié ?</a>
                </div>
            @endif
        </form>
        
        <div class="register-link">
            Pas de compte ? <a href="{{ route('register') }}">S'inscrire</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

