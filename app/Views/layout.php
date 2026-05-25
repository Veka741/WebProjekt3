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
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        nav a:hover {
            opacity: 0.8;
        }

        main {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .alert {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 5px;
            display: none;
        }

        .alert.show {
            display: block;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">🐱 Portál adopce koček</div>
                <ul>
                    <li>
                        <?= anchor('/', 'O nás', 'nav-link'); ?>
                    </li>
                    <li>
                        <?= anchor('gallery', 'Galerie', 'nav-link'); ?>
                    </li>
                    <li>
                        <?= anchor('manage', 'Správa', 'nav-link'); ?>
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
            <p>&copy; 2026 Portál adopce koček. Všechna práva vyhrazena.</p>
        </div>
    </footer>
</body>
</html>
