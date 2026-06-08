<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="gallery-section">
    <h1>Galerie dostupných koček</h1>
    
    <?php if (empty($cats)): ?>
        <div style="background-color: white; padding: 3rem; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <p style="font-size: 1.3rem; color: #787f9bff; margin-bottom: 1.5rem;">Zatím nejsou dostupné žádné kočky.</p>
        </div>
    <?php else: ?>
        <div class="cats-grid">
            <?php foreach ($cats as $cat): ?>
                <div class="cat-card">
                    <div class="cat-photo">
                        <?php if (!empty($cat['photo'] ?? null)): ?>
                            <img src="<?= base_url('images/'.$cat['photo'].'.jpg') ?>" alt="<?= $cat['name'] ?>">
                        <?php else: ?>
                            <div class="placeholder">🐱</div>
                        <?php endif; ?>
                    </div>

                    <div class="cat-info">
                        <h3><?= $cat['name'] ?></h3>
                        <p class="breed"><?= $cat['breed'] ?? 'Neznámé plemeno' ?></p>
                        <p class="details">
                            <span><?= $cat['age'] ?> let</span> • 
                            <span><?= $cat['gender'] === 'male' ? 'Kluk' : 'Holka' ?></span>
                        </p>

                        <?php if ($cat['description']): ?>
                            <p class="description"><?= substr($cat['description'], 0, 150) ?>...</p>
                        <?php endif; ?>

                        <div class="card-footer">
                            <span class="contact">Kontakt: <?= $cat['user_id'] ?? 'Neznámý uživatel' ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .gallery-section h1 {
        color: #767b94ff;
        margin-bottom: 2rem;
        font-size: 2rem;
        text-align: center;
    }

    .cats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .cat-card {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .cat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .cat-photo {
        width: 100%;
        height: 250px;
        overflow: hidden;
        background-color: #f0f0f0;
    }

    .cat-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
        background: linear-gradient(135deg, #8d93adff 0%, #764ba2 100%);
    }

    .cat-info {
        padding: 1.5rem;
    }

    .cat-info h3 {
        color: #667eea;
        margin-bottom: 0.5rem;
        font-size: 1.3rem;
    }

    .breed {
        font-size: 1rem;
        color: #666;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    .details {
        font-size: 0.9rem;
        color: #999;
        margin-bottom: 1rem;
    }

    .description {
        font-size: 0.9rem;
        color: #555;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .card-footer {
        border-top: 1px solid #eee;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .contact {
        font-size: 0.85rem;
        color: #999;
    }

    @media (max-width: 768px) {
        .cats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?= $this->endSection() ?>
