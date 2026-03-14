<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Connexion' }} - YA Consulting</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', 'Segoe UI', sans-serif; }
        .auth-bg {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 70%, #6366f1 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            padding: 40px 36px;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 28px;
        }
        .auth-logo a {
            text-decoration: none;
            color: inherit;
        }
        .auth-logo h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e1b4b;
            letter-spacing: -0.5px;
        }
        .auth-logo p {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 4px;
        }
        .auth-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #1e1b4b;
            margin-bottom: 24px;
            text-align: center;
        }
        .auth-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .auth-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        .auth-label {
            display: block;
            font-weight: 600;
            font-size: 0.875rem;
            color: #374151;
            margin-bottom: 6px;
        }
        .auth-error {
            font-size: 0.8rem;
            color: #dc2626;
            margin-top: 4px;
        }
        .auth-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .auth-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(79,70,229,0.4);
        }
        .auth-link {
            color: #4f46e5;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .auth-link:hover { text-decoration: underline; }
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.8);
        }
        .auth-footer a { color: #fff; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body class="antialiased">
    <div class="auth-bg">
        <div class="auth-card">
            <div class="auth-logo">
                <a href="{{ url('/') }}">
                    <h1>YA Consulting</h1>
                    <p>Logiciel de Facturation</p>
                </a>
            </div>
            {{ $slot }}
        </div>
        <div class="auth-footer">
            <a href="{{ url('/') }}">← Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>
