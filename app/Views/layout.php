
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Portál adopce koček' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        nav a {
            color: white;
            text-decoration: none;
            transition: all 0.3s;
            padding: 0.5rem 1rem;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        main {
            min-height: calc(100vh - 200px);
            padding: 3rem 0;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.1);
        }

        .alert {
            padding: 1rem 1.5rem;
            margin: 1rem 0;
            border-radius: 8px;
            display: none;
            border-left: 4px solid;
            animation: slideIn 0.3s ease-out;
        }

        .alert.show {
            display: block;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                flex-direction: column;
                gap: 0.5rem;
                width: 100%;
            }

            .logo {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">🐱 Adopce Koček</div>
                <ul>
                    <li>
                        <?= anchor('/', 'Domů', 'nav-link'); ?>
                    </li>
                    <li>
                        <?= anchor('gallery', 'Galerie', 'nav-link'); ?>
                    </li>
                    <li>
                        <?= anchor('success', 'Úspěšné adopce', 'nav-link'); ?>
                    </li>
                    <li>
                        <?= anchor('manage', 'Správa', 'nav-link'); ?>
                    </li>
                    <li>
                        <?= anchor('admin_users', 'Uživatelé', 'nav-link'); ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success show">
                    ✓ <?= session('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-error show">
                    ✗ <?= session('error') ?>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Portál adopce koček. Všechna práva vyhrazena. 💚</p>
        </div>
    </footer>
</body>
</html>
