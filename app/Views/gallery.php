<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="gallery-section">
    <h1>🐱 Galerie koček</h1>
    
    <?php if (empty($cats)): ?>
        <div style="background-color: #f0f0f0; padding: 2rem; border-radius: 8px; text-align: center; margin-top: 2rem;">
            <p style="font-size: 1.1rem; color: #666;">Zatím nejsou k dispozici žádné kočky.</p>
            <a href="/manage" style="color: #667eea; text-decoration: none;">→ Přidat první kočku</a>
        </div>
    <?php else: ?>
        <div class="cats-grid">
            <?php foreach ($cats as $cat): ?>
                <div class="cat-card">
                    <?php if ($cat['photo']): ?>
                        <div class="cat-photo">
                            <img src="<?= base_url('uploads/' . $cat['photo']) ?>" alt="<?= $cat['name'] ?>">
                        </div>
                    <?php else: ?>
                        <div class="cat-photo placeholder">
                            <span>🐱</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="cat-info">
                        <h3><?= $cat['name'] ?></h3>
                        <p><strong>Plemeno:</strong> <?= $cat['breed'] ?></p>
                        <p><strong>Věk:</strong> <?= $cat['age'] ?> let</p>
                        <p><strong>Typ uživatele:</strong> <?= ucfirst($cat['user_type']) ?></p>
                        <p><strong>Kontakt:</strong> <?= $cat['user_name'] ?></p>
                        
                        <?php if ($cat['description']): ?>
                            <div class="description">
                                <p><strong>Popis:</strong></p>
                                <p><?= $cat['description'] ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <small style="color: #999;">Přidáno: <?= date('d. m. Y H:i', strtotime($cat['created_at'])) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .gallery-section h1 {
        color: #667eea;
        margin-bottom: 2rem;
        font-size: 2rem;
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
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .cat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }

    .cat-photo {
        width: 100%;
        height: 250px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cat-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cat-photo.placeholder {
        font-size: 80px;
    }

    .cat-info {
        padding: 1.5rem;
    }

    .cat-info h3 {
        color: #667eea;
        margin-bottom: 0.5rem;
        font-size: 1.3rem;
    }

    .cat-info p {
        margin: 0.5rem 0;
        color: #555;
    }

    .description {
        background-color: #f9f9f9;
        padding: 1rem;
        border-radius: 5px;
        margin-top: 1rem;
        font-size: 0.95rem;
    }
</style>
<?= $this->endSection() ?>
