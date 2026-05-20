<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Jimpitan Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #059669;
            --accent: #34D399;
            --text-main: #1F2937;
            --text-muted: #6B7280;
        }

        /* Advanced Aesthetic Brighter Background */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: #ECFDF5; /* Brighter Mint Base */
            overflow: hidden;
            position: relative;
        }

        .bg-aura {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            overflow: hidden;
        }

        .blob {
            position: absolute;
            width: 600px;
            height: 600px;
            filter: blur(100px);
            border-radius: 50%;
            opacity: 0.6;
            animation: move 25s infinite alternate;
        }

        .blob-1 { top: -150px; left: -150px; background: #6EE7B7; animation-delay: 0s; }
        .blob-2 { bottom: -200px; right: -150px; background: #34D399; animation-delay: -5s; }
        .blob-3 { top: 10%; right: 5%; background: #A7F3D0; width: 400px; height: 400px; animation-delay: -10s; }
        .blob-4 { bottom: 20%; left: 10%; background: #D1FAE5; width: 350px; height: 350px; animation-delay: -15s; }

        /* Tech Dot Grid Overlay - Brighter */
        .bg-grid {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            background-image: radial-gradient(rgba(16, 185, 129, 0.15) 1px, transparent 1px);
            background-size: 40px 40px;
            opacity: 0.8;
        }

        /* Floating Particles */
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
            opacity: 0.3;
            z-index: 3;
            animation: float-up 10s infinite linear;
        }

        @keyframes float-up {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            50% { opacity: 0.5; }
            100% { transform: translateY(-100px) scale(1.5); opacity: 0; }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 20px;
        }

        /* Professional Aesthetic Card: Glassmorphism with Sharp Definition */
        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-radius: 32px;
            padding: 4.5rem 3.5rem;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 
                0 30px 60px -12px rgba(0, 0, 0, 0.4),
                inset 0 0 0 1px rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
        }

        /* Logo Pulse Glow */
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .logo-box {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 1.8rem;
            box-shadow: 0 12px 20px -8px rgba(16, 185, 129, 0.4);
            transform: rotate(-5deg);
            transition: transform 0.3s ease;
            animation: pulse-glow 2s infinite;
        }

        /* Floating Glass Elements */
        .glass-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            z-index: 5;
            animation: float-alt 8s ease-in-out infinite;
        }

        @keyframes float-alt {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(15deg); }
        }

        h1 {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.025em;
            margin-bottom: 0.5rem;
        }

        p.subtitle {
            color: var(--text-muted);
            font-size: 1rem;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            margin-left: 0.5rem;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.25rem 1rem 3rem;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.05);
            background: white;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            color: var(--text-main);
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 1.1rem;
            color: var(--text-muted);
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
        }

        .toggle-password {
            position: absolute;
            right: 1.1rem;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 1rem;
            padding: 5px;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

        .btn-submit {
            width: 100%;
            padding: 1.125rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.25);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(16, 185, 129, 0.3);
        }

        .alert-error {
            background: #FEF2F2;
            color: #991B1B;
            padding: 1rem;
            border-radius: 14px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 2rem;
            border: 1px solid #FEE2E2;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .footer {
            margin-top: 2.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .footer b {
            color: var(--primary);
        }

    </style>
</head>
<body>
    <div class="bg-aura">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="blob blob-4"></div>
    </div>
    <div class="bg-grid"></div>

    <!-- Floating Particles -->
    <div class="particle" style="left: 10%; animation-delay: 0s;"></div>
    <div class="particle" style="left: 30%; animation-delay: 2s;"></div>
    <div class="particle" style="left: 50%; animation-delay: 4s;"></div>
    <div class="particle" style="left: 70%; animation-delay: 6s;"></div>
    <div class="particle" style="left: 90%; animation-delay: 8s;"></div>
    <div class="particle" style="left: 20%; animation-delay: 1s;"></div>
    <div class="particle" style="left: 45%; animation-delay: 3s;"></div>
    <div class="particle" style="left: 65%; animation-delay: 5s;"></div>
    <div class="particle" style="left: 85%; animation-delay: 7s;"></div>

    <div class="glass-element" style="width: 60px; height: 60px; top: 15%; left: 15%; animation-delay: 0s; color: var(--primary);">
        <i class="fas fa-shield-halved"></i>
    </div>
    <div class="glass-element" style="width: 80px; height: 80px; bottom: 10%; left: 10%; animation-delay: -2s; font-size: 2rem; color: var(--primary-dark);">
        <i class="fas fa-qrcode"></i>
    </div>
    <div class="glass-element" style="width: 50px; height: 50px; top: 25%; right: 12%; animation-delay: -4s; font-size: 1.2rem; color: var(--primary);">
        <i class="fas fa-chart-line"></i>
    </div>
    <div class="glass-element" style="width: 70px; height: 70px; top: 60%; right: 8%; animation-delay: -1s; font-size: 1.8rem; color: var(--primary-dark);">
        <i class="fas fa-paper-plane"></i>
    </div>
    <div class="glass-element" style="width: 45px; height: 45px; bottom: 25%; right: 20%; animation-delay: -3s; font-size: 1.1rem; color: var(--primary);">
        <i class="fas fa-wifi"></i>
    </div>
    <div class="glass-element" style="width: 55px; height: 55px; top: 10%; right: 40%; animation-delay: -5s; font-size: 1.3rem; color: var(--primary-dark);">
        <i class="fas fa-user-lock"></i>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="header">
                <div class="logo-box">
                    <i class="fas fa-leaf"></i>
                </div>
                <h1>Jimpitan <span style="color: var(--primary);">Online</span></h1>
                <p class="subtitle">Kelola keuangan RT dengan mudah</p>
            </div>

            @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-circle-exclamation" style="font-size: 1.2rem;"></i>
                Username atau password tidak valid.
            </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <input type="text" name="email" class="form-control" placeholder="admin" value="admin" required autofocus>
                        <i class="fas fa-user-circle input-icon"></i>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom: 0.5rem;">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" value="admin123" required>
                        <i class="fas fa-lock input-icon"></i>
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit">Masuk ke Dashboard</button>
            </form>
            
            <div class="footer">
                <i class="fas fa-shield-check"></i> Sistem Keamanan <b>Terenkripsi</b>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
