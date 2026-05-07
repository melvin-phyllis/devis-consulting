<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'devis-consulting')</title>
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
            --surface: #f8fafc;
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
            background: var(--surface);
            color: var(--navy);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px;
            height: 100vh;
            background: var(--brand-dark);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 4px;
        }

        .sidebar-header {
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            flex-shrink: 0;
        }

        .sidebar-logo {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 12px 0;
            display: flex;
            flex-direction: column;
        }

        .nav-section {
            padding: 16px 20px 5px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.45);
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px 9px 28px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.82);
            font-size: 13.5px;
            font-weight: 400;
            transition: background 0.15s, color 0.15s;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
        }

        .nav-link.active::after {
            background: #7c6bfe;
            box-shadow: 0 0 6px rgba(124,107,254,0.8);
        }

        .nav-link-create {
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
        }

        .nav-link-create::after {
            display: none;
        }

        .nav-link-create .nav-icon {
            display: inline;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.09);
            color: #fff;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.13);
            color: #fff;
            font-weight: 500;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 4px;
            bottom: 4px;
            width: 3px;
            background: #7c6bfe;
            border-radius: 0 2px 2px 0;
        }

        .nav-icon {
            display: none;
        }

        .nav-count {
            margin-left: auto;
            font-size: 10px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.55);
            background: rgba(255, 255, 255, 0.12);
            padding: 1px 7px;
            border-radius: 10px;
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
            flex-shrink: 0;
        }

        .user-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .user-row:hover {
            background: rgba(255, 255, 255, 0.06);
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--purple);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            flex-shrink: 0;
        }

        .user-info {
            min-width: 0;
            overflow: hidden;
        }

        .user-name {
            font-size: 12.5px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.85);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 10.5px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            margin-top: 8px;
            padding: 7px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 4px;
            background: transparent;
            color: rgba(255, 255, 255, 0.6);
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 400;
            cursor: pointer;
            transition: all 0.15s;
        }

        .logout-btn:hover {
            border-color: rgba(239, 68, 68, 0.4);
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
        }

        /* ── Main content ── */
        .main-content {
            margin-left: 240px;
            flex: 1;
            padding: 32px 36px;
            min-height: 100vh;
        }

        /* ── Page header ── */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
        }

        .page-header h1 {
            font-size: 22px;
            font-weight: 400;
            color: var(--navy);
            letter-spacing: -0.3px;
        }

        .page-header-sub {
            font-size: 13px;
            color: var(--slate);
            font-weight: 300;
            margin-top: 3px;
        }

        /* ── Cards ── */
        .content-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 20px;
        }

        /* ── Flash alerts ── */
        .alert {
            padding: 10px 16px;
            border-radius: 4px;
            margin-bottom: 16px;
            font-size: 13px;
            font-weight: 400;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        /* ── Buttons ── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-weight: 400;
            font-size: 13px;
            text-decoration: none;
            transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
            white-space: nowrap;
            line-height: 1.4;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background: var(--purple);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--purple-hover);
            box-shadow: var(--shadow-blue) 0 4px 12px -4px, var(--shadow-black) 0 2px 6px -2px;
        }

        .btn-success {
            background: #16a34a;
            color: #fff;
        }

        .btn-success:hover {
            background: #15803d;
        }

        .btn-danger {
            background: #dc2626;
            color: #fff;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-warning {
            background: #d97706;
            color: #fff;
        }

        .btn-warning:hover {
            background: #b45309;
        }

        .btn-secondary {
            background: #fff;
            color: var(--dark-slate);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--surface);
            border-color: #c7d4e0;
        }

        .btn-info {
            background: #0891b2;
            color: #fff;
        }

        .btn-info:hover {
            background: #0e7490;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--purple);
            color: var(--purple);
        }

        .btn-outline:hover {
            background: rgba(83, 58, 253, 0.05);
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-lg {
            padding: 11px 24px;
            font-size: 15px;
        }

        .btn-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        /* ── Tables ── */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: var(--surface);
            color: var(--dark-slate);
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
            font-size: 13px;
            color: var(--dark-slate);
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--surface);
        }

        /* ── Badges ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-success {
            background: rgba(21, 190, 83, 0.12);
            color: #15803d;
            border: 1px solid rgba(21, 190, 83, 0.25);
        }

        .badge-warning {
            background: rgba(234, 146, 38, 0.1);
            color: #b45309;
            border: 1px solid rgba(234, 146, 38, 0.25);
        }

        .badge-danger {
            background: rgba(220, 38, 38, 0.08);
            color: #b91c1c;
            border: 1px solid rgba(220, 38, 38, 0.2);
        }

        .badge-info {
            background: rgba(83, 58, 253, 0.08);
            color: var(--purple);
            border: 1px solid rgba(83, 58, 253, 0.2);
        }

        .badge-neutral {
            background: var(--surface);
            color: var(--slate);
            border: 1px solid var(--border);
        }

        /* ── Forms ── */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--dark-slate);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 4px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 300;
            color: var(--navy);
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(83, 58, 253, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        /* ── Empty states ── */
        .empty-state {
            text-align: center;
            padding: 56px 20px;
            color: var(--slate);
        }

        .empty-state-icon {
            font-size: 2.5em;
            margin-bottom: 12px;
            opacity: 0.4;
        }

        .empty-state h2 {
            font-size: 16px;
            font-weight: 400;
            color: var(--dark-slate);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 13px;
            font-weight: 300;
            line-height: 1.6;
        }

        .empty-state a {
            color: var(--purple);
            text-decoration: none;
            font-weight: 400;
        }

        /* ── Modals ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(6, 27, 49, 0.45);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 28px;
            max-width: 400px;
            width: 100%;
            box-shadow: var(--shadow-blue) 0px 20px 40px -15px, var(--shadow-black) 0px 10px 20px -10px;
        }

        .modal-box h3 {
            font-size: 16px;
            font-weight: 500;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .modal-box p {
            font-size: 13px;
            color: var(--slate);
            font-weight: 300;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        /* ── Mobile ── */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 14px;
            left: 14px;
            z-index: 200;
            background: var(--brand-dark);
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
        }

        @media (max-width: 900px) {
            .mobile-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
                padding-top: 60px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @yield('styles')
</head>

<body>

    <button class="mobile-toggle" onclick="document.querySelector('.sidebar').classList.toggle('open')">☰</button>

    {{-- ── Sidebar ── --}}
    <aside class="sidebar">
        <div class="sidebar-header" style="display:flex;justify-content:center;">
            <a href="{{ route('dashboard') }}" class="sidebar-logo">
                <div
                    style="background:#fff;border-radius:8px;padding:10px 16px;display:inline-flex;align-items:center;">
                    <img src="{{ asset('image/logo-devis.png') }}" alt="Devis-Consulting" style="height:80px;width:auto;">
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section">Principal</span>

            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">▪</span> Tableau de bord
            </a>

            <span class="nav-section">Gestion</span>

            <a href="{{ route('clients.index') }}"
                class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                <span class="nav-icon">▪</span> Clients
                <span class="nav-count">{{ \App\Models\Client::count() }}</span>
            </a>

            <a href="{{ route('produits.index') }}"
                class="nav-link {{ request()->routeIs('produits.*') ? 'active' : '' }}">
                <span class="nav-icon">▪</span> Produits &amp; services
            </a>

            <span class="nav-section">Documents</span>

            <a href="{{ route('devis.index') }}"
                class="nav-link {{ request()->routeIs('devis.index') || request()->routeIs('devis.show') ? 'active' : '' }}">
                <span class="nav-icon">▪</span> Devis
                <span class="nav-count">{{ \App\Models\Document::where('type', 'devis')->count() }}</span>
            </a>

            <a href="{{ route('devis.create') }}"
                class="nav-link nav-link-create {{ request()->routeIs('devis.create') ? 'active' : '' }}">
                <span class="nav-icon">+</span> Nouveau devis
            </a>

            <a href="{{ route('factures.index') }}"
                class="nav-link {{ request()->routeIs('factures.*') ? 'active' : '' }}">
                <span class="nav-icon">▪</span> Factures
                <span class="nav-count">{{ \App\Models\Document::where('type', 'facture')->count() }}</span>
            </a>

            <span class="nav-section">Compte</span>

            <a href="{{ route('settings.edit') }}"
                class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <span class="nav-icon">▪</span> Paramètres
            </a>

            <a href="{{ route('profile.edit') }}"
                class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <span class="nav-icon">▪</span> Mon profil
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('profile.edit') }}" class="user-row">
                <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ Auth::user()->name ?? 'Utilisateur' }}</div>
                    <div class="user-role">{{ Auth::user()->email ?? '' }}</div>
                </div>
            </a>
            <button type="button" class="logout-btn"
                onclick="document.getElementById('modal-logout').classList.add('open')">
                Déconnexion
            </button>
        </div>
    </aside>

    {{-- Modal déconnexion --}}
    <div class="modal-overlay" id="modal-logout">
        <div class="modal-box">
            <h3>Confirmer la déconnexion</h3>
            <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary"
                    onclick="document.getElementById('modal-logout').classList.remove('open')">Annuler</button>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Déconnexion</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal suppression (réutilisable) --}}
    <div class="modal-overlay" id="modal-delete">
        <div class="modal-box">
            <h3>Confirmer la suppression</h3>
            <p id="delete-modal-message">Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.
            </p>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="window.closeDeleteModal()">Annuler</button>
                <button type="button" class="btn btn-danger" id="delete-modal-confirm">Supprimer</button>
            </div>
        </div>
    </div>

    {{-- Modal bienvenue (première connexion) --}}
    <div class="modal-overlay" id="modal-welcome">
        <div class="modal-box" style="max-width:480px;">
            <div style="text-align:center;margin-bottom:20px;">
                <div style="width:56px;height:56px;background:rgba(83,58,253,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 14px;">👋</div>
                <h3 style="font-size:18px;margin-bottom:6px;">Bienvenue sur votre espace !</h3>
                <p style="margin-bottom:0;">Votre compte est prêt. Pour générer des devis et factures avec vos coordonnées, commencez par <strong>renseigner les informations de votre entreprise</strong> dans les paramètres — cela prend moins d'une minute.</p>
            </div>
            <div style="background:var(--surface);border:1px solid var(--border);border-radius:5px;padding:12px 14px;margin-bottom:22px;font-size:12px;color:var(--slate);">
                <strong style="color:var(--navy);display:block;margin-bottom:4px;">Ce dont vous aurez besoin :</strong>
                Nom de l'entreprise &nbsp;·&nbsp; Adresse &nbsp;·&nbsp; Téléphone &nbsp;·&nbsp; Email &nbsp;·&nbsp; Logo (optionnel)
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('modal-welcome').classList.remove('open')">Plus tard</button>
                <a href="{{ route('settings.edit') }}" class="btn btn-primary">Configurer mon entreprise</a>
            </div>
        </div>
    </div>

    {{-- Modal paramètres incomplets --}}
    <div class="modal-overlay" id="modal-settings-incomplete">
        <div class="modal-box" style="max-width:440px;">
            <div style="text-align:center;margin-bottom:18px;">
                <div style="width:48px;height:48px;background:rgba(234,88,12,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 12px;">⚠️</div>
                <h3 style="font-size:16px;margin-bottom:6px;">Paramètres incomplets</h3>
                <p style="margin-bottom:0;">Certaines informations essentielles de votre entreprise (nom, adresse, téléphone, email) ne sont pas encore renseignées.<br><br>Vos PDF ne pourront pas afficher les coordonnées correctes.</p>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('modal-settings-incomplete').classList.remove('open')">Ignorer</button>
                <a href="{{ route('settings.edit') }}" class="btn btn-primary">Compléter les paramètres</a>
            </div>
        </div>
    </div>

    {{-- ── Main content ── --}}
    <main class="main-content">

        @if(session('success'))
            <div class="alert alert-success">✓ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">✗ {{ session('error') }}</div>
        @endif

        @yield('content')

    </main>

    <script>
        (function () {
            @if(session('show_welcome_modal'))
                document.addEventListener('DOMContentLoaded', function () {
                    document.getElementById('modal-welcome').classList.add('open');
                });
            @elseif(session('show_settings_modal'))
                document.addEventListener('DOMContentLoaded', function () {
                    document.getElementById('modal-settings-incomplete').classList.add('open');
                });
            @endif

            ['modal-welcome', 'modal-settings-incomplete'].forEach(function (id) {
                var el = document.getElementById(id);
                if (el) {
                    el.addEventListener('click', function (e) {
                        if (e.target === this) this.classList.remove('open');
                    });
                }
            });

            window.openDeleteModal = function (form, message) {
                window._deleteFormToSubmit = form;
                document.getElementById('delete-modal-message').textContent = message || 'Êtes-vous sûr de vouloir supprimer cet élément ?';
                document.getElementById('modal-delete').classList.add('open');
            };
            window.closeDeleteModal = function () {
                window._deleteFormToSubmit = null;
                document.getElementById('modal-delete').classList.remove('open');
            };
            document.getElementById('delete-modal-confirm').addEventListener('click', function () {
                if (window._deleteFormToSubmit) window._deleteFormToSubmit.submit();
                window.closeDeleteModal();
            });
            ['modal-logout', 'modal-delete'].forEach(function (id) {
                document.getElementById(id).addEventListener('click', function (e) {
                    if (e.target === this) {
                        if (id === 'modal-delete') window.closeDeleteModal();
                        else this.classList.remove('open');
                    }
                });
            });
        })();
    </script>
    @yield('scripts')
</body>

</html>
