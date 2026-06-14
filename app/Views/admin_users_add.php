<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="form-section">
    <h1> Přidat nového uživatele</h1>

    <?php if (!empty($errors ?? [])): ?>
        <div class="alert alert-error show" style="margin-bottom: 2rem;">
            <strong>Chyby ve formuláři:</strong>
            <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                <?php foreach ($errors ?? [] as $field => $error): ?>
                    <li><strong><?= ucfirst($field) ?>:</strong> <?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="user-form">
        <?= csrf_field() ?>

        <div class="form-row">
            <div class="form-group">
                <label for="first_name">Jméno *</label>
                <input type="text" id="first_name" name="first_name" value="<?= old('first_name') ?>" required>
                <small>Minimálně 2 znaky</small>
            </div>

            <div class="form-group">
                <label for="last_name">Příjmení *</label>
                <input type="text" id="last_name" name="last_name" value="<?= old('last_name') ?>" required>
                <small>Minimálně 2 znaky</small>
            </div>
        </div>

        <div class="form-group">
            <label for="username">Uživatelské jméno *</label>
            <input type="text" id="username" name="username" value="<?= old('username') ?>" required>
            <small>Minimálně 3 znaky, bez mezer</small>
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?= old('email') ?>" required>
            <small>Musí být jedinečný a platný</small>
        </div>

        <div class="form-group">
            <label for="password">Heslo *</label>
            <input type="password" id="password" name="password" required>
            <small>Minimálně 6 znaků</small>
        </div>

        <div class="form-group">
            <label for="role">Role *</label>
            <select id="role" name="role" required>
                <option value="">-- Vyberte roli --</option>
                <option value="user" <?= old('role') === 'user' ? 'selected' : '' ?>>Uživatel</option>
                <option value="volunteer" <?= old('role') === 'volunteer' ? 'selected' : '' ?>>Dobrovolník</option>
                <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Administrátor</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">Přidat uživatele</button>
            <a href="/admin/users" class="btn btn-secondary btn-large">← Zpět</a>
        </div>
    </form>
</div>

<style>
    .form-section {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 700px;
        margin: 0 auto;
    }

    .form-section h1 {
        color: #33665a;
        margin-bottom: 2rem;
        font-size: 2rem;
    }

    .user-form {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    label {
        font-weight: bold;
        color: #333;
        margin-bottom: 0.5rem;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    textarea,
    select {
        padding: 0.7rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: inherit;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    input:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: #33665a;
        box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
    }

    small {
        font-size: 0.85rem;
        color: #999;
        margin-top: 0.3rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        display: inline-block;
        padding: 0.8rem 1.5rem;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        border: none;
        font-size: 1rem;
        transition: all 0.3s;
        font-weight: 500;
    }

    .btn-large {
        padding: 1rem 2rem;
        font-size: 1.1rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #33665a 0%, #22463c 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary {
        background-color: #999;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #777;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
        padding: 1rem;
        border-radius: 5px;
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>
<?= $this->endSection() ?>