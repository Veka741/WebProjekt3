<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Přihlášení – Portál adopce koček') ?></title>
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            flex-direction: column;
        }

        /* ── header matching layout.php ── */
        header {
            background: linear-gradient(135deg, #bec4dfff 0%, #000000ff 100%);
            color: white;
            padding: 1.5rem 0;
            box-shadow: 0 4px 15px rgba(0,0,0,.2);
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .logo      { font-size: 1.8rem; font-weight: bold; }

        /* ── login card ── */
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
        }

        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,.12);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
        }

        .login-card h1 {
            text-align: center;
            font-size: 1.6rem;
            color: #2c3e50;
            margin-bottom: .4rem;
        }
        .login-card p.sub {
            text-align: center;
            color: #777;
            margin-bottom: 1.8rem;
            font-size: .95rem;
        }

        /* messages from Ion Auth */
        .ia-message {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
            border-radius: 6px;
            padding: .85rem 1rem;
            margin-bottom: 1.2rem;
            font-size: .9rem;
        }
        .ia-message ul { list-style: none; padding: 0; }

        .form-group { margin-bottom: 1.2rem; }
        label {
            display: block;
            font-weight: 600;
            font-size: .9rem;
            color: #444;
            margin-bottom: .4rem;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: .7rem 1rem;
            border: 1.5px solid #d1d9e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color .2s, box-shadow .2s;
            color: #333;
        }
        input:focus {
            outline: none;
            border-color: #7c90d4;
            box-shadow: 0 0 0 3px rgba(124,144,212,.2);
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1.5rem;
            font-size: .9rem;
            color: #555;
        }
        .remember-row input[type="checkbox"] { width: 16px; height: 16px; cursor: pointer; }

        .btn-login {
            width: 100%;
            padding: .85rem;
            background: linear-gradient(135deg, #bec4dfff 0%, #2c3e50 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            letter-spacing: .02em;
            transition: opacity .2s, transform .1s;
        }
        .btn-login:hover  { opacity: .9; }
        .btn-login:active { transform: scale(.98); }

        .forgot-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #7c90d4;
            font-size: .9rem;
            text-decoration: none;
        }
        .forgot-link:hover { text-decoration: underline; }

        .default-hint {
            margin-top: 1.5rem;
            padding: .75rem 1rem;
            background: #e8f4fd;
            border-left: 4px solid #7c90d4;
            border-radius: 6px;
            font-size: .82rem;
            color: #555;
            line-height: 1.5;
        }
        .default-hint strong { color: #2c3e50; }

        footer {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 1.5rem 0;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <div class="logo">🐱 Adopce Koček</div>
    </div>
</header>

<main>
    <div class="login-card">
        <h1>Přihlášení</h1>
        <p class="sub">Zadejte své přihlašovací údaje pro přístup do administrace</p>

        <?php if (!empty($message)): ?>
            <div class="ia-message"><?= $message ?></div>
        <?php endif; ?>

        <?= form_open('auth/login') ?>

            <div class="form-group">
                <label for="identity">E-mail</label>
                <?= form_input($identity, '', ['placeholder' => 'váš@email.cz', 'autocomplete' => 'email']) ?>
            </div>

            <div class="form-group">
                <label for="password">Heslo</label>
                <?= form_input($password, '', ['placeholder' => '••••••••', 'autocomplete' => 'current-password']) ?>
            </div>

            <label class="remember-row">
                <?= form_checkbox('remember', '1', false, ['id' => 'remember']) ?>
                Zapamatovat přihlášení
            </label>

            <?= form_submit('submit', 'Přihlásit se', ['class' => 'btn-login']) ?>

        <?= form_close() ?>

        <a class="forgot-link" href="<?= site_url('auth/forgot_password') ?>">Zapomněli jste heslo?</a>

        <!-- Development hint – remove in production -->
        <div class="default-hint">
            <strong>Výchozí přihlašovací údaje:</strong><br>
            E-mail: <strong>admin@admin.com</strong><br>
            Heslo: <strong>password</strong>
        </div>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; 2026 Portál adopce koček. Všechna práva vyhrazena.</p>
    </div>
</footer>

</body>
</html>
