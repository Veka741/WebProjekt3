
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="manage-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h1>📋 Správa inzerátů</h1>
        <a href="/manage/add" class="btn btn-primary">+ Přidat novou kočku</a>
    </div>

    <?php if (empty($cats)): ?>
        <div style="background-color: white; padding: 3rem; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <p style="font-size: 1.3rem; color: #667eea; margin-bottom: 1.5rem;">🎉 Zatím jste nepřidali žádné kočky.</p>
            <a href="/manage/add" class="btn btn-primary btn-large">Přidat první kočku</a>
        </div>
    <?php else: ?>
        <div class="cats-cards">
            <?php foreach ($cats as $cat): ?>
                <div class="cat-management-card">
                    <div class="card-header">
                        <?php if (!empty($cat['photo'] ?? null)): ?>
                            <img src="<?= base_url('uploads/' . $cat['photo']) ?>" alt="<?= $cat['name'] ?>">
                        <?php else: ?>
                            <div class="placeholder-image">🐱</div>
                        <?php endif; ?>
                        <div class="status-badge <?= $cat['status'] ?>">
                            <?php if ($cat['status'] === 'adopted'): ?>
                                ✓ Adoptovaná
                            <?php else: ?>
                                ✓ Dostupná
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card-body">
                        <h3><?= $cat['name'] ?></h3>
                        <div class="info-row">
                            <span class="label">Plemeno:</span>
                            <span><?= $cat['breed'] ?? 'Neznámé plemeno' ?></span>
                        </div>
                        <div class="info-row">
                            <span class="label">Věk:</span>
                            <span><?= $cat['age'] ?> let</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Pohlaví:</span>
                            <span><?= ucfirst($cat['gender']) ?></span>
                        </div>
                        <?php if ($cat['description']): ?>
                            <div class="description-preview">
                                <?= substr($cat['description'], 0, 100) ?>...
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-actions">
                        <a href="/manage/edit/<?= $cat['id'] ?>" class="btn btn-small btn-edit">✏️ Editovat</a>
                        <?php if ($cat['status'] !== 'adopted'): ?>
                            <a href="/manage/adopt/<?= $cat['id'] ?>" class="btn btn-small btn-adopt" onclick="return confirm('Označit tuto kočku jako adoptovanou?');">💚 Adoptovaná</a>
                        <?php endif; ?>
                        <a href="/manage/soft-delete/<?= $cat['id'] ?>" class="btn btn-small btn-archive" onclick="return confirm('Archivovat tuto kočku? (Lze obnovit)'); ">📦 Archivovat</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .manage-section h1 {
        color: #667eea;
        font-size: 2rem;
    }

    .btn {
        display: inline-block;
        padding: 0.7rem 1.5rem;
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

    .btn-small {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }

    .btn-edit {
        background-color: #4caf50;
        color: white;
    }

    .btn-edit:hover {
        background-color: #45a049;
    }

    .btn-adopt {
        background-color: #2196f3;
        color: white;
    }

    .btn-adopt:hover {
        background-color: #0b7dda;
    }

    .btn-archive {
        background-color: #ff9800;
        color: white;
    }

    .btn-archive:hover {
        background-color: #e68900;
    }

    .cats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .cat-management-card {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }

    .cat-management-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .card-header {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .card-header img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .placeholder-image {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
    }

    .status-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: bold;
        color: white;
    }

    .status-badge.available {
        background-color: rgba(76, 175, 80, 0.9);
    }

    .status-badge.adopted {
        background-color: rgba(33, 150, 243, 0.9);
    }

    .card-body {
        padding: 1.5rem;
        flex-grow: 1;
    }

    .card-body h3 {
        color: #667eea;
        margin-bottom: 1rem;
        font-size: 1.3rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin: 0.7rem 0;
        font-size: 0.95rem;
    }

    .info-row .label {
        font-weight: bold;
        color: #666;
    }

    .info-row span {
        color: #333;
    }

    .description-preview {
        background-color: #f5f5f5;
        padding: 0.8rem;
        border-radius: 5px;
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #666;
        border-left: 3px solid #667eea;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
        padding: 1rem;
        border-top: 1px solid #eee;
        flex-wrap: wrap;
    }

    .card-actions .btn {
        flex: 1;
        min-width: 100px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .cats-cards {
            grid-template-columns: 1fr;
        }

        .card-actions {
            flex-direction: column;
        }

        .card-actions .btn {
            width: 100%;
        }
    }
</style>
<?= $this->endSection() ?>
