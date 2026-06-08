<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="success-section">
    <div class="success-header">
        <h1>💚 Úspěšné adopce</h1>
        <p>Zde jsou všechny koček, které našly svůj nový domov!</p>
    </div>

    <?php if (empty($cats)): ?>
        <div style="background-color: white; padding: 3rem; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <p style="font-size: 1.2rem; color: #667eea; margin-bottom: 1rem;">Zatím nejsou žádné adoptované kočky.</p>
            <a href="/gallery" style="color: #667eea; text-decoration: none; font-weight: bold;">→ Podívejte se na naši galerii</a>
        </div>
    <?php else: ?>
        <div class="success-grid">
            <?php foreach ($cats as $cat): ?>
                <div class="success-card">
                    <div class="success-image">
                        <?php if ($cat['photo']): ?>
                            <img src="<?= base_url('uploads/' . $cat['photo']) ?>" alt="<?= $cat['name'] ?>">
                        <?php else: ?>
                            <div class="placeholder">🐱</div>
                        <?php endif; ?>
                        <div class="adopted-badge">✓ ADOPTOVANÁ</div>
                    </div>

                    <div class="success-info">
                        <h3><?= $cat['name'] ?></h3>
                        <p class="cat-details">
                            <strong><?= $cat['breed'] ?></strong> • <?= $cat['age'] ?> let • 
                            <span class="gender">
                                <?= $cat['gender'] === 'male' ? '♂️ Samec' : '♀️ Samice' ?>
                            </span>
                        </p>

                        <?php if ($cat['description']): ?>
                            <div class="cat-description">
                                <p><?= $cat['description'] ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="adoption-details">
                            <div class="detail-item">
                                <span class="detail-label">Adoptováno:</span>
                                <span><?= date('d. m. Y', strtotime($cat['adopted_at'] ?? $cat['created_at'])) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .success-section {
        padding: 0;
    }

    .success-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 3rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .success-header h1 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .success-header p {
        font-size: 1.1rem;
        opacity: 0.95;
    }

    .success-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .success-card {
        background-color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .success-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .success-image {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
    }

    .success-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 80px;
    }

    .adopted-badge {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.95) 0%, rgba(56, 142, 60, 0.95) 100%);
        color: white;
        padding: 1rem;
        text-align: center;
        font-weight: bold;
        font-size: 1rem;
        letter-spacing: 1px;
    }

    .success-info {
        padding: 1.5rem;
    }

    .success-info h3 {
        color: #667eea;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .cat-details {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }

    .gender {
        font-weight: bold;
    }

    .cat-description {
        background-color: #f9f9f9;
        padding: 1rem;
        border-radius: 6px;
        margin: 1rem 0;
        border-left: 3px solid #667eea;
    }

    .cat-description p {
        color: #555;
        line-height: 1.6;
    }

    .adoption-details {
        background-color: #f0f7ff;
        padding: 1rem;
        border-radius: 6px;
        margin-top: 1rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        margin: 0.5rem 0;
        font-size: 0.9rem;
    }

    .detail-label {
        font-weight: bold;
        color: #667eea;
    }

    .detail-item span:last-child {
        color: #333;
    }

    @media (max-width: 768px) {
        .success-header h1 {
            font-size: 1.8rem;
        }

        .success-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<?= $this->endSection() ?>