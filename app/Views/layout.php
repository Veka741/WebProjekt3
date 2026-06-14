<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Adopce koček' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Karla:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #355c4d;
            --green-dark: #243f35;
            --terra: #c2603f;
            --terra-dark: #a84e30;
            --paper: #f3eee3;
            --card: #fffdf8;
            --ink: #2b2a26;
            --muted: #6f6a5f;
            --line: #e3dccc;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Karla', 'Segoe UI', system-ui, sans-serif;
            background-color: var(--paper);
            color: var(--ink);
            min-height: 100vh;
            line-height: 1.6;
        }

        h1, h2, h3, h4 {
            font-family: 'Fraunces', Georgia, 'Times New Roman', serif;
            font-weight: 600;
            line-height: 1.2;
            color: var(--green-dark);
        }

        a { color: var(--terra-dark); }

        .container { max-width: 1140px; margin: 0 auto; padding: 0 24px; }

        /* ---- Header ---- */
        header {
            background-color: var(--green-dark);
            color: #fff;
            border-bottom: 4px solid var(--terra);
            box-shadow: 0 3px 12px rgba(0,0,0,.18);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        header .container { padding-top: .9rem; padding-bottom: .9rem; }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .logo {
            font-family: 'Fraunces', Georgia, serif;
            font-size: 1.85rem;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.3px;
        }
        .logo .dot { color: var(--terra); }

        nav ul {
            list-style: none;
            display: flex;
            gap: .35rem;
            flex-wrap: wrap;
            align-items: center;
        }

        nav ul a {
            color: #f7f2e7;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            padding: .5rem .9rem;
            border-radius: 7px;
            transition: background-color .15s, color .15s;
        }
        nav ul a:hover { background-color: rgba(255,255,255,.16); color: #fff; }
        nav ul a.active { background-color: var(--terra); color: #fff; }

        main { min-height: calc(100vh - 210px); padding: 2.6rem 0 3.2rem; }

        /* ---- Footer ---- */
        footer {
            background-color: var(--green-dark);
            color: #cdd6cf;
            text-align: center;
            padding: 1.6rem 0;
            font-size: .92rem;
        }

        /* ---- Alerts ---- */
        .alert {
            padding: .85rem 1.2rem;
            margin-bottom: 1.6rem;
            border-radius: 4px;
            border-left: 4px solid;
            font-size: .98rem;
        }
        .alert-success { background-color: #e7efe6; color: #2c4a35; border-left-color: var(--green); }
        .alert-error   { background-color: #f6e3dd; color: #7c2f1c; border-left-color: var(--terra-dark); }

        /* ---- Breadcrumbs ---- */
        .breadcrumb {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: .4rem;
            margin-bottom: 1.8rem;
            font-size: .92rem;
            color: var(--muted);
        }
        .breadcrumb-item + .breadcrumb-item::before { content: "/"; padding-right: .4rem; color: #b8b0a0; }
        .breadcrumb-item a { color: var(--terra-dark); text-decoration: none; }
        .breadcrumb-item a:hover { text-decoration: underline; }
        .breadcrumb-item.active { color: var(--muted); }

        /* ---- Modal ---- */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(36, 63, 53, .55);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 6px;
            padding: 1.8rem;
            max-width: 430px;
            width: 90%;
            box-shadow: 0 14px 40px rgba(36,63,53,.25);
        }
        .modal-box h3 { color: var(--terra-dark); margin-bottom: .9rem; }
        .modal-box p { margin-bottom: 1.4rem; color: var(--ink); }
        .modal-actions { display: flex; gap: .8rem; justify-content: flex-end; }
        .modal-actions .btn {
            padding: .55rem 1.2rem; border-radius: 4px; text-decoration: none;
            border: none; cursor: pointer; font-size: .95rem; color: #fff; font-family: inherit;
        }
        .modal-btn-cancel { background: #8d877a; }
        .modal-btn-confirm { background: var(--terra-dark); }

        @media (max-width: 768px) {
            nav { flex-direction: column; align-items: flex-start; gap: .8rem; }
            nav ul { gap: 1rem; }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <?php
                $cur = trim(uri_string(), '/');
                $active = fn (string $p) => ($p === '' ? $cur === '' : str_starts_with($cur, $p)) ? 'active' : '';
            ?>
            <nav>
                <a href="<?= site_url('/') ?>" class="logo" style="text-decoration:none">Adopce koček<span class="dot">.</span></a>
                <ul>
                    <li><a href="<?= site_url('/') ?>" class="<?= $active('') ?>">Domů</a></li>
                    <li><a href="<?= site_url('gallery') ?>" class="<?= $active('gallery') ?>">Galerie</a></li>
                    <li><a href="<?= site_url('success') ?>" class="<?= $active('success') ?>">Úspěšné adopce</a></li>
                    <?php if ((bool) session('user_id')): ?>
                        <li><a href="<?= site_url('manage') ?>" class="<?= $active('manage') ?>">Správa</a></li>
                        <li><a href="<?= site_url('admin/users') ?>" class="<?= $active('admin') ?>">Uživatelé</a></li>
                        <li><a href="<?= site_url('auth/logout') ?>">Odhlásit</a></li>
                    <?php else: ?>
                        <li><a href="<?= site_url('auth/login') ?>" class="<?= $active('auth') ?>">Přihlásit</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success"><?= session('success') ?></div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-error"><?= session('error') ?></div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Adopce koček &middot; studentský projekt</p>
        </div>
    </footer>
</body>
</html>
