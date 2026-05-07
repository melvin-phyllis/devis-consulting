<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>devis-consulting — Gérez vos devis et factures</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:200,300,400,500,600" rel="stylesheet">
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: var(--navy);
            font-size: 16px;
            line-height: 1.5;
            font-weight: 300;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Navigation ── */
        nav {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 0 max(24px, calc((100vw - 1080px) / 2));
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
        }

        .nav-logo {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-nav {
            display: inline-flex;
            align-items: center;
            padding: 7px 14px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 400;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.15s;
            border: none;
            cursor: pointer;
        }

        .btn-nav-ghost {
            color: var(--dark-slate);
        }

        .btn-nav-ghost:hover {
            color: var(--purple);
        }

        .btn-nav-primary {
            background: var(--purple);
            color: #fff;
        }

        .btn-nav-primary:hover {
            background: var(--purple-hover);
        }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 22px;
            background: var(--purple);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 400;
            text-decoration: none;
            transition: background 0.15s, transform 0.15s;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--purple-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 22px;
            background: transparent;
            color: var(--purple);
            border: 1px solid #b9b9f9;
            border-radius: 4px;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 400;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
            cursor: pointer;
        }

        .btn-outline:hover {
            background: rgba(83, 58, 253, 0.04);
            border-color: var(--purple);
        }

        /* ── Hero ── */
        .hero {
            padding: 96px max(24px, calc((100vw - 1080px) / 2)) 80px;
            text-align: center;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(83, 58, 253, 0.06);
            border: 1px solid rgba(83, 58, 253, 0.18);
            border-radius: 4px;
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 500;
            color: var(--purple);
            letter-spacing: 0.2px;
            margin-bottom: 32px;
        }

        .hero h1 {
            font-size: 54px;
            font-weight: 300;
            line-height: 1.05;
            letter-spacing: -1.3px;
            color: var(--navy);
            max-width: 680px;
            margin: 0 auto 22px;
        }

        .hero h1 span {
            color: var(--purple);
        }

        .hero-sub {
            font-size: 18px;
            font-weight: 300;
            line-height: 1.6;
            color: var(--slate);
            max-width: 500px;
            margin: 0 auto 40px;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 64px;
            flex-wrap: wrap;
        }

        /* ── Mock dashboard ── */
        .hero-preview {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: var(--shadow-blue) 0px 40px 70px -25px, var(--shadow-black) 0px 20px 40px -20px;
            overflow: hidden;
            text-align: left;
        }

        .preview-topbar {
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .preview-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .preview-body {
            display: flex;
            min-height: 320px;
        }

        .preview-sidebar {
            width: 190px;
            background: var(--brand-dark);
            padding: 16px 0;
            flex-shrink: 0;
        }

        .preview-brand {
            padding: 4px 16px 14px;
            font-size: 12px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 8px;
            letter-spacing: 0.2px;
        }

        .preview-nav-item {
            padding: 7px 16px;
            font-size: 11px;
            color: rgba(255, 255, 255, 0.55);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .preview-nav-item.active {
            background: rgba(255, 255, 255, 0.09);
            color: #fff;
        }

        .preview-nav-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
        }

        .preview-nav-item.active .preview-nav-dot {
            background: var(--purple);
        }

        .preview-content {
            flex: 1;
            padding: 18px;
            background: #f8fafc;
            overflow: hidden;
        }

        .preview-title {
            font-size: 11px;
            font-weight: 600;
            color: var(--navy);
            margin-bottom: 12px;
        }

        .preview-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 12px;
        }

        .preview-stat {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 10px 12px;
        }

        .p-label {
            font-size: 8.5px;
            color: var(--slate);
            font-weight: 400;
            margin-bottom: 3px;
        }

        .p-value {
            font-size: 15px;
            font-weight: 600;
            color: var(--navy);
            letter-spacing: -0.5px;
        }

        .p-badge {
            display: inline-block;
            font-size: 7.5px;
            font-weight: 500;
            padding: 2px 5px;
            border-radius: 3px;
            margin-top: 4px;
        }

        .preview-table {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
        }

        .preview-thead {
            display: grid;
            grid-template-columns: 2.5fr 1.2fr 1.2fr 0.8fr;
            padding: 7px 12px;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
        }

        .p-th {
            font-size: 8px;
            color: var(--slate);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .preview-row {
            display: grid;
            grid-template-columns: 2.5fr 1.2fr 1.2fr 0.8fr;
            padding: 7px 12px;
            border-bottom: 1px solid var(--border);
            align-items: center;
        }

        .preview-row:last-child {
            border-bottom: none;
        }

        .p-td {
            font-size: 9.5px;
            color: var(--navy);
        }

        .p-ref {
            color: var(--purple);
            font-weight: 500;
            font-size: 9px;
        }

        .p-status {
            display: inline-block;
            font-size: 7.5px;
            font-weight: 500;
            padding: 2px 6px;
            border-radius: 3px;
        }

        /* ── Features ── */
        .features {
            padding: 88px max(24px, calc((100vw - 1080px) / 2));
            background: #fff;
        }

        .section-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--purple);
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 38px;
            font-weight: 300;
            letter-spacing: -0.75px;
            color: var(--navy);
            line-height: 1.1;
            margin-bottom: 14px;
        }

        .section-sub {
            font-size: 17px;
            color: var(--slate);
            font-weight: 300;
            line-height: 1.6;
            max-width: 460px;
            margin-bottom: 52px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .feature-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 28px 24px;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .feature-card:hover {
            box-shadow: var(--shadow-blue) 0px 20px 40px -20px, var(--shadow-black) 0px 10px 20px -10px;
            transform: translateY(-2px);
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: rgba(83, 58, 253, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 18px;
        }

        .feature-card h3 {
            font-size: 16px;
            font-weight: 500;
            color: var(--navy);
            margin-bottom: 8px;
            letter-spacing: -0.15px;
        }

        .feature-card p {
            font-size: 14px;
            color: var(--slate);
            font-weight: 300;
            line-height: 1.65;
        }

        /* ── How it works ── */
        .how {
            padding: 88px max(24px, calc((100vw - 1080px) / 2));
            background: #f8fafc;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .how-header {
            text-align: center;
            margin-bottom: 52px;
        }

        .how-header .section-sub {
            margin: 0 auto;
        }

        .how-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .how-step {
            text-align: center;
            padding: 36px 24px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            transition: box-shadow 0.2s;
        }

        .how-step:hover {
            box-shadow: var(--shadow-blue) 0px 16px 32px -16px, var(--shadow-black) 0px 8px 16px -8px;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--purple);
            color: #fff;
            font-size: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .how-step h3 {
            font-size: 17px;
            font-weight: 500;
            color: var(--navy);
            margin-bottom: 10px;
            letter-spacing: -0.2px;
        }

        .how-step p {
            font-size: 14px;
            color: var(--slate);
            font-weight: 300;
            line-height: 1.65;
        }

        /* ── CTA dark ── */
        .cta-section {
            padding: 88px max(24px, calc((100vw - 1080px) / 2));
            background: var(--brand-dark);
            text-align: center;
        }

        .cta-section h2 {
            font-size: 40px;
            font-weight: 300;
            letter-spacing: -0.8px;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 16px;
        }

        .cta-section p {
            font-size: 17px;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 300;
            max-width: 400px;
            margin: 0 auto 36px;
            line-height: 1.6;
        }

        .btn-primary-lg {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 13px 30px;
            background: var(--purple);
            color: #fff;
            border: none;
            border-radius: 4px;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 400;
            text-decoration: none;
            transition: background 0.15s, transform 0.15s;
            cursor: pointer;
        }

        .btn-primary-lg:hover {
            background: var(--purple-hover);
            transform: translateY(-1px);
        }

        /* ── Footer ── */
        footer {
            padding: 22px max(24px, calc((100vw - 1080px) / 2));
            background: var(--brand-dark);
            border-top: 1px solid rgba(255, 255, 255, 0.07);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        footer p {
            font-size: 12.5px;
            color: rgba(255, 255, 255, 0.35);
            font-weight: 300;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {

            .features-grid,
            .how-steps {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero h1 {
                font-size: 40px;
                letter-spacing: -0.8px;
            }

            .section-title {
                font-size: 30px;
            }

            .preview-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .hero {
                padding-top: 64px;
            }

            .hero h1 {
                font-size: 32px;
                letter-spacing: -0.5px;
            }

            .features-grid,
            .how-steps {
                grid-template-columns: 1fr;
            }

            .hero-preview {
                display: none;
            }

            footer {
                flex-direction: column;
                gap: 6px;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    {{-- Navigation --}}
    <nav>
        <a href="/" class="nav-logo">
            <img src="/image/logo-devis.png" alt="Devis-Consulting" style="height:80px;width:auto;">
        </a>
        <div class="nav-actions">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-nav btn-nav-primary">Tableau de bord →</a>
            @else
                <a href="{{ route('login') }}" class="btn-nav btn-nav-ghost">Se connecter</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-nav btn-nav-primary">Commencer gratuitement</a>
                @endif
            @endauth
        </div>
    </nav>

    {{-- Hero --}}
    <section class="hero">
        <div class="hero-badge">✦ Gestion de devis &amp; factures pour pros</div>

        <h1>Facturez plus vite,<br><span>encaissez plus sûr.</span></h1>

        <p class="hero-sub">
            Créez des devis professionnels en quelques clics, convertissez-les en factures
            et suivez vos paiements en temps réel.
        </p>

        <div class="hero-actions">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary">Accéder au tableau de bord →</a>
            @else
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary">Créer un compte gratuitement →</a>
                @endif
                <a href="{{ route('login') }}" class="btn-outline">Se connecter</a>
            @endauth
        </div>

        {{-- Faux aperçu du dashboard --}}
        <div class="hero-preview">
            <div class="preview-topbar">
                <div class="preview-dot" style="background:#ff5f57;"></div>
                <div class="preview-dot" style="background:#febc2e;"></div>
                <div class="preview-dot" style="background:#28c840;"></div>
            </div>
            <div class="preview-body">
                <div class="preview-sidebar">
                    <div class="preview-brand">devis.consulting</div>
                    <div class="preview-nav-item active">
                        <div class="preview-nav-dot"></div>Tableau de bord
                    </div>
                    <div class="preview-nav-item">
                        <div class="preview-nav-dot"></div>Devis
                    </div>
                    <div class="preview-nav-item">
                        <div class="preview-nav-dot"></div>Factures
                    </div>
                    <div class="preview-nav-item">
                        <div class="preview-nav-dot"></div>Clients
                    </div>
                    <div class="preview-nav-item">
                        <div class="preview-nav-dot"></div>Produits
                    </div>
                </div>
                <div class="preview-content">
                    <div class="preview-title">Tableau de bord — Mai 2026</div>
                    <div class="preview-stats">
                        <div class="preview-stat">
                            <div class="p-label">CA Prévu</div>
                            <div class="p-value">4 750 000</div>
                            <div class="p-badge" style="background:rgba(83,58,253,0.1);color:#533afd;">12 devis</div>
                        </div>
                        <div class="preview-stat">
                            <div class="p-label">CA Encaissé</div>
                            <div class="p-value">2 100 000</div>
                            <div class="p-badge" style="background:rgba(21,190,83,0.15);color:#108c3d;">Soldées ✓</div>
                        </div>
                        <div class="preview-stat">
                            <div class="p-label">En attente</div>
                            <div class="p-value">2 650 000</div>
                            <div class="p-badge" style="background:rgba(234,146,38,0.1);color:#b45309;">3 factures</div>
                        </div>
                    </div>
                    <div class="preview-table">
                        <div class="preview-thead">
                            <div class="p-th">Référence</div>
                            <div class="p-th">Client</div>
                            <div class="p-th">Montant</div>
                            <div class="p-th">Statut</div>
                        </div>
                        <div class="preview-row">
                            <div class="p-ref">YAC-FAC-ABJ-202605-0041</div>
                            <div class="p-td">Tech Solutions</div>
                            <div class="p-td" style="font-weight:500;">850 000 FCFA</div>
                            <div><span class="p-status"
                                    style="background:rgba(21,190,83,0.15);color:#108c3d;">Soldée</span></div>
                        </div>
                        <div class="preview-row">
                            <div class="p-ref">YAC-FAC-ABJ-202605-0040</div>
                            <div class="p-td">Global Corp</div>
                            <div class="p-td" style="font-weight:500;">1 200 000 FCFA</div>
                            <div><span class="p-status"
                                    style="background:rgba(234,146,38,0.1);color:#b45309;">Partielle</span></div>
                        </div>
                        <div class="preview-row">
                            <div class="p-ref">YAC-DV-ABJ-202605-0039</div>
                            <div class="p-td">Groupe Elite</div>
                            <div class="p-td" style="font-weight:500;">600 000 FCFA</div>
                            <div><span class="p-status"
                                    style="background:rgba(83,58,253,0.1);color:#533afd;">Devis</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section class="features">
        <div class="section-eyebrow">Fonctionnalités</div>
        <h2 class="section-title">Tout ce qu'il faut pour facturer.</h2>
        <p class="section-sub">
            Une suite complète pour gérer votre activité commerciale,
            de la prospection à l'encaissement.
        </p>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📄</div>
                <h3>Devis professionnels</h3>
                <p>Numérotation automatique, logo et cachet intégrés. Téléchargez un PDF prêt à envoyer en un clic.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Conversion instantanée</h3>
                <p>Transformez un devis accepté en facture d'un seul clic — toutes les informations sont reprises
                    automatiquement.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💳</div>
                <h3>Suivi des paiements</h3>
                <p>Enregistrez les règlements partiels ou complets. Visualisez les factures soldées, en retard ou en
                    attente.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Gestion des clients</h3>
                <p>Centralisez vos contacts avec leurs informations légales (RCCM, CC). Consultez l'historique complet
                    par client.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📦</div>
                <h3>Catalogue produits</h3>
                <p>Gérez vos produits et services avec leurs prix. Ajoutez-les à vos documents en quelques secondes.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Tableau de bord</h3>
                <p>CA prévu vs encaissé, taux de conversion des devis, alertes sur les factures en retard — tout en un
                    coup d'œil.</p>
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section class="how">
        <div class="how-header">
            <div class="section-eyebrow">Comment ça marche</div>
            <h2 class="section-title">Trois étapes, c'est tout.</h2>
            <p class="section-sub">Opérationnel en moins de 5 minutes, sans formation requise.</p>
        </div>

        <div class="how-steps">
            <div class="how-step">
                <div class="step-number">1</div>
                <h3>Configurez votre entreprise</h3>
                <p>Renseignez votre nom, logo, cachet et TVA. Ces informations s'appliquent automatiquement à tous vos
                    documents PDF.</p>
            </div>
            <div class="how-step">
                <div class="step-number">2</div>
                <h3>Créez et partagez vos devis</h3>
                <p>Ajoutez vos produits, sélectionnez votre client et téléchargez le PDF. Propre et professionnel en
                    moins de 2 minutes.</p>
            </div>
            <div class="how-step">
                <div class="step-number">3</div>
                <h3>Facturez et encaissez</h3>
                <p>Convertissez les devis validés en factures, enregistrez les paiements et suivez votre chiffre
                    d'affaires en temps réel.</p>
            </div>
        </div>
    </section>

    {{-- CTA dark section --}}
    <section class="cta-section">
        <h2>Prêt à professionnaliser<br>votre facturation ?</h2>
        <p>Rejoignez les entreprises qui gèrent leurs devis et factures sans effort.</p>

        @auth
            <a href="{{ url('/dashboard') }}" class="btn-primary-lg">Accéder à mon espace →</a>
        @else
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-primary-lg">Créer un compte gratuitement →</a>
            @endif
        @endauth
    </section>

    {{-- Footer --}}
    <footer>
        <p>
            © {{ date('Y') }} devis-consulting
        </p>

        <p>
            Conçu par
            <a href="https://www.linkedin.com/in/ange-nguegno-18801737a/" target="_blank" rel="noopener"
                style="color:rgba(255,255,255,0.55);text-decoration:none;transition:color 0.15s;"
                onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">Ange
                Nguegno</a>
        </p>

        <p>
            Maintenue Par
            <a href="https://www.linkedin.com/in/melvin-akou/" target="_blank" rel="noopener"
                style="color:rgba(255,255,255,0.55);text-decoration:none;transition:color 0.15s;"
                onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">Akou
                Melvin</a>

        </p>

    </footer>

</body>

</html>
