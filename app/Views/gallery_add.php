<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?= (new \App\Libraries\Breadcrumb())->render(['Domů' => '/', 'Galerie fotek' => '/gallery', 'Přidat fotku' => null]) ?>

<div class="form-section">
    <h1>Přidat fotku</h1>

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

    <form method="POST" enctype="multipart/form-data" class="cat-form">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="cat_id">Kočka *</label>
            <select id="cat_id" name="cat_id" required>
                <option value="" disabled <?= old('cat_id') ? '' : 'selected' ?>>-- Vyberte kočku --</option>
                <?php foreach ($cats ?? [] as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= (string) old('cat_id') === (string) $cat['id'] ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <small>Načítá se z databáze (tabulka cats)</small>
        </div>

        <div class="form-group">
            <label for="photo">Soubor s fotkou *</label>
            <input type="file" id="photo" name="photo" accept="image/*" required>
            <small>Max. 2 MB (JPG, PNG, GIF, WEBP)</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">Nahrát fotku</button>
            <a href="/gallery" class="btn btn-secondary btn-large">← Zpět</a>
        </div>
    </form>
</div>

<style>
    .form-section {
        background: #fff; padding: 2rem; border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto;
    }
    .form-section h1 { color: #33665a; margin-bottom: 2rem; font-size: 2rem; }
    .cat-form { display: flex; flex-direction: column; }
    .form-group { margin-bottom: 1.5rem; display: flex; flex-direction: column; }
    label { font-weight: bold; color: #333; margin-bottom: 0.5rem; }
    select, input[type="file"] {
        padding: 0.7rem; border: 1px solid #ddd; border-radius: 5px; font-size: 1rem;
    }
    small { font-size: 0.85rem; color: #999; margin-top: 0.3rem; }
    .form-actions { display: flex; gap: 1rem; margin-top: 1rem; }
    .btn {
        padding: 0.8rem 1.5rem; border-radius: 6px; text-decoration: none; cursor: pointer;
        border: none; font-size: 1rem; font-weight: 500;
    }
    .btn-large { padding: 1rem 2rem; font-size: 1.1rem; }
    .btn-primary { background: linear-gradient(135deg, #33665a 0%, #22463c 100%); color: #fff; }
    .btn-secondary { background: #999; color: #fff; }
</style>
<?= $this->endSection() ?>
