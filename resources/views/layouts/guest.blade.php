<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Connexion' }} — devis-consulting</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:200,300,400,500,600" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --purple: #533afd;
            --purple-hover: #4434d4;
            --navy: #061b31;
            --slate: #64748d;
            --dark-slate: #273951;
            --border: #e5edf5;
            --brand-dark: #1c1e54;
            --shadow-blue: rgba(50, 50, 93, 0.25);
            --shadow-black: rgba(0, 0, 0, 0.1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-weight: 300;
            background: #ffffff;
            color: var(--navy);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Panneau gauche (branding) ── */
        .auth-left {
            width: 420px;
            flex-shrink: 0;
            background: var(--brand-dark);
            display: flex;
            flex-direction: column;
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }

        /* Décoration de fond subtile */
        .auth-left::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 360px;
            height: 360px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(83, 58, 253, 0.35) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-left::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(83, 58, 253, 0.2) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-left-logo {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            margin-bottom: auto;
        }

        .auth-left-content {
            margin-top: auto;
            padding-top: 48px;
        }

        .auth-left-content h2 {
            font-size: 28px;
            font-weight: 300;
            color: #fff;
            line-height: 1.2;
            letter-spacing: -0.5px;
            margin-bottom: 12px;
        }

        .auth-left-content p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.55);
            font-weight: 300;
            line-height: 1.65;
            margin-bottom: 32px;
        }

        .auth-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .auth-features li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 300;
        }

        .auth-feature-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(83, 58, 253, 0.3);
            border: 1px solid rgba(83, 58, 253, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            flex-shrink: 0;
        }

        .auth-left-footer {
            margin-top: 48px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.25);
            font-weight: 300;
        }

        /* ── Panneau droit (formulaire) ── */
        .auth-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            background: #ffffff;
        }

        .auth-form-wrap {
            width: 100%;
            max-width: 380px;
        }

        .auth-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--slate);
            text-decoration: none;
            font-weight: 400;
            margin-bottom: 36px;
            transition: color 0.15s;
        }

        .auth-back:hover {
            color: var(--purple);
        }

        /* Classes utilisées dans les vues auth individuelles */
        .auth-title {
            font-size: 26px;
            font-weight: 300;
            color: var(--navy);
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }

        .auth-subtitle {
            font-size: 14px;
            color: var(--slate);
            font-weight: 300;
            margin-bottom: 28px;
        }

        .auth-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--dark-slate);
            margin-bottom: 6px;
        }

        .auth-input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 300;
            color: var(--navy);
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }

        .auth-input::placeholder {
            color: #a0aec0;
        }

        .auth-input:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(83, 58, 253, 0.1);
        }

        .auth-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
            font-weight: 400;
        }

        .auth-btn {
            width: 100%;
            padding: 11px 20px;
            background: var(--purple);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 400;
            cursor: pointer;
            transition: background 0.15s, transform 0.15s;
            margin-top: 8px;
        }

        .auth-btn:hover {
            background: var(--purple-hover);
            transform: translateY(-1px);
        }

        .auth-link {
            color: var(--purple);
            text-decoration: none;
            font-weight: 400;
            font-size: 13px;
            transition: opacity 0.15s;
        }

        .auth-link:hover {
            opacity: 0.75;
        }

        .auth-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 24px 0;
        }

        /* Erreurs globales */
        .auth-alert {
            padding: 10px 14px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 4px;
            font-size: 13px;
            color: #b91c1c;
            margin-bottom: 20px;
            font-weight: 300;
        }

        .auth-alert ul {
            list-style: disc;
            padding-left: 16px;
        }

        .auth-alert li {
            margin-top: 2px;
        }

        /* Statut succès */
        .auth-status {
            padding: 10px 14px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 4px;
            font-size: 13px;
            color: #15803d;
            margin-bottom: 20px;
            font-weight: 300;
        }

        /* Champ + label groupés */
        .space-y-5>*+* {
            margin-top: 18px;
        }

        /* ── Responsive ── */
        @media (max-width: 820px) {
            .auth-left {
                display: none;
            }

            .auth-right {
                padding: 40px 24px;
            }

            /* Mini logo en haut sur mobile */
            .auth-right::before {
                content: 'devis.consulting';
                display: block;
                position: absolute;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                font-size: 16px;
                font-weight: 500;
                color: var(--navy);
                letter-spacing: -0.2px;
            }
        }
    </style>
</head>

<body>

    {{-- Panneau gauche --}}
    <div class="auth-left">

        <div style="text-align:center;">
            <a href="{{ url('/') }}" class="auth-left-logo">
                <div
                    style="background:#fff;border-radius:8px;padding:10px 16px;display:inline-flex;align-items:center;">
                    <img src="/image/logo-devis.png" alt="Devis-Consulting" style="height:80px;width:auto;">
                </div>
            </a>
        </div>

        <div class="auth-left-content">
            <h2>La facturation pro,<br>enfin simple.</h2>
            <p>Gérez vos devis, factures et paiements depuis un seul endroit. Conçu pour les entreprises d'Afrique
                francophone.</p>

            <ul class="auth-features">
                <li>
                    <span class="auth-feature-dot">✓</span>
                    Devis et factures PDF professionnels
                </li>
                <li>
                    <span class="auth-feature-dot">✓</span>
                    Suivi des paiements en temps réel
                </li>
                <li>
                    <span class="auth-feature-dot">✓</span>
                    Tableau de bord CA prévu vs encaissé
                </li>
                <li>
                    <span class="auth-feature-dot">✓</span>
                    Multi-entreprises, données isolées
                </li>
            </ul>
        </div>

        <div class="auth-left-footer">© {{ date('Y') }} devis-consulting</div>
    </div>

    {{-- Panneau droit --}}
    <div class="auth-right">
        <div class="auth-form-wrap">
            <a href="{{ url('/') }}" class="auth-back">← Retour à l'accueil</a>
            {{ $slot }}
        </div>
    </div>

</body>

</html>
