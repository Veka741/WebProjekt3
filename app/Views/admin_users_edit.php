<?= $this->extend('layout') ?>

<?= (new \App\Libraries\Breadcrumb())->render(['Domů' => '/', 'Správa uživatelů' => '/admin/users', 'Editace uživatele' => null]) ?>
<div class="form-section">
    <h1>Editovat uživatele</h1>

    <?php if (!empty($errors ?? [])): ?>
        <div class="alert alert-error show" style="margin-bottom: 2rem;">
            <strong>Chyby ve formuláři:</strong>
            <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                <?php foreach ($errors ?? [] as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="user-form">
        <?= csrf_field() ?>
        <div class="form-row">
            <div class="form-group">
                <label for="first_name">Jméno *</label>
                <input type="text" id="first_name" name="first_name" value="<?= esc($user['first_name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Příjmení *</label>
                <input type="text" id="last_name" name="last_name" value="<?= esc($user['last_name'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="<?= esc($user['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="role">Role *</label>
            <select id="role" name="role" required>
                <option value="" disabled <?= empty($user['role']) ? 'selected' : '' ?>>-- Vyberte roli --</option>
                <option value="user"      <?= ($user['role'] ?? '') === 'user' ? 'selected' : '' ?>>Uživatel</option>
                <option value="volunteer" <?= ($user['role'] ?? '') === 'volunteer' ? 'selected' : '' ?>>Dobrovolník</option>
                <option value="admin"     <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrátor</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">✓ Uložit změny</button>
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
        color: #667eea;
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
    input[type="tel"],
    textarea,
    select {
        padding: 0.7rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: inherit;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
    }

    textarea {
        resize: vertical;
        min-height: 100px;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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