<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="form-section">
    <h1>✏️ Editovat kočku</h1>

    <form method="POST" action="/manage/update/<?= $cat['id'] ?>" enctype="multipart/form-data" class="cat-form">
        <div class="form-group">
            <label for="name">Jméno kočky *</label>
            <input type="text" id="name" name="name" required value="<?= $cat['name'] ?>">
        </div>

        <div class="form-group">
            <label for="breed">Plemeno *</label>
            <input type="text" id="breed" name="breed" required value="<?= $cat['breed'] ?>">
        </div>

        <div class="form-group">
            <label for="age">Věk (v letech) *</label>
            <input type="number" id="age" name="age" required min="0" max="30" value="<?= $cat['age'] ?>" step="0.5">
        </div>

        <div class="form-group">
            <label for="description">Popis</label>
            <textarea id="description" name="description" rows="5"><?= $cat['description'] ?></textarea>
        </div>

        <div class="form-group">
            <label for="photo">Fotka (JPG, PNG)</label>
            <?php if ($cat['photo']): ?>
                <div style="margin-bottom: 1rem;">
                    <img src="<?= base_url('uploads/' . $cat['photo']) ?>" alt="<?= $cat['name'] ?>" style="max-width: 200px; border-radius: 5px;">
                    <p style="color: #999; font-size: 0.9rem; margin-top: 0.5rem;">Aktuální fotka</p>
                </div>
            <?php endif; ?>
            <input type="file" id="photo" name="photo" accept="image/*">
            <small>Nechejte prázdné, pokud nechcete měnit fotku. Maximální velikost: 5MB</small>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="user_name">Vaše jméno/Název útulny *</label>
                <input type="text" id="user_name" name="user_name" required value="<?= $cat['user_name'] ?>">
            </div>

            <div class="form-group">
                <label for="user_type">Typ uživatele *</label>
                <select id="user_type" name="user_type" required>
                    <option value="">Vyberte typ...</option>
                    <option value="private" <?= $cat['user_type'] === 'private' ? 'selected' : '' ?>>Soukromá osoba</option>
                    <option value="shelter" <?= $cat['user_type'] === 'shelter' ? 'selected' : '' ?>>Útulna/Azyl</option>
                    <option value="organization" <?= $cat['user_type'] === 'organization' ? 'selected' : '' ?>>Organizace</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Uložit změny</button>
            <a href="/manage" class="btn btn-secondary">← Zpět</a>
        </div>
    </form>
</div>

<style>
    .form-section {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    .form-section h1 {
        color: #667eea;
        margin-bottom: 2rem;
        font-size: 2rem;
    }

    .cat-form {
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
    input[type="number"],
    input[type="file"],
    textarea,
    select {
        padding: 0.7rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: inherit;
        font-size: 1rem;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="file"]:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
    }

    textarea {
        resize: vertical;
    }

    small {
        color: #999;
        font-size: 0.85rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-secondary {
        background-color: #ccc;
        color: #333;
    }

    .btn-secondary:hover {
        background-color: #bbb;
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
<?= $this->endSection() ?>
