<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?= (new \App\Libraries\Breadcrumb())->render($crumbs ?? ['Domů' => '/', 'Správa koček' => '/manage', $cat['name'] => null]) ?>

<div class="detail-section">
    <div class="detail-card">
        <div class="detail-image">
            <?php if (!empty($photo['image_path'])): ?>
                <img src="<?= base_url('images/' . $photo['image_path']) ?>" alt="<?= esc($cat['name']) ?>"
                     onerror="this.parentNode.innerHTML='<div class=&quot;placeholder&quot;>🐱</div>';">
            <?php else: ?>
                <div class="placeholder">🐱</div>
            <?php endif; ?>
        </div>

        <div class="detail-body">
            <h1><?= esc($cat['name']) ?></h1>

            <div class="detail-meta">
                <span><strong>Plemeno:</strong> <?= esc($breedName) ?></span>
                <span><strong>Věk:</strong> <?= (int) $cat['age'] ?> let</span>
                <span><strong>Pohlaví:</strong> <?= $cat['gender'] === 'male' ? 'Kluk' : 'Holka' ?></span>
                <span><strong>Stav:</strong> <?= esc($cat['status']) ?></span>
            </div>

            <h2>Podrobný popis</h2>
            <div class="long-text">
                <?php if (!empty($cat['long_description'])): ?>
                    <?= $cat['long_description'] // záměrně bez esc – formátovaný HTML obsah z WYSIWYG editoru ?>
                <?php else: ?>
                    <p><em>Žádný podrobný popis zatím nebyl vyplněn.</em></p>
                <?php endif; ?>
            </div>

            <div class="detail-actions">
                <a href="/manage/edit/<?= $cat['id'] ?>" class="btn btn-primary">Editovat</a>
                <a href="<?= esc($backUrl ?? '/manage', 'attr') ?>" class="btn btn-secondary"><?= esc($backLabel ?? '← Zpět na seznam') ?></a>
            </div>
        </div>
    </div>
</div>

<style>
    .detail-card {
        background: #fff; border-radius: 12px; overflow: hidden; max-width: 900px; margin: 0 auto;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .detail-image { width: 100%; height: 360px; overflow: hidden; }
    .detail-image img { width: 100%; height: 100%; object-fit: cover; }
    .detail-image .placeholder {
        width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
        font-size: 100px; background: linear-gradient(135deg, #9098bd 0%, #856e9c 100%);
    }
    .detail-body { padding: 2rem; }
    .detail-body h1 { color: #667eea; font-size: 2rem; margin-bottom: 1rem; }
    .detail-body h2 { color: #764ba2; font-size: 1.2rem; margin: 1.5rem 0 0.8rem; border-bottom: 2px solid #eee; padding-bottom: 0.3rem; }
    .detail-meta { display: flex; flex-wrap: wrap; gap: 1.5rem; color: #555; margin-bottom: 1rem; }
    .long-text {
        background: #f9f9f9; border-left: 4px solid #667eea; border-radius: 6px;
        padding: 1.2rem 1.5rem; color: #444; line-height: 1.7;
    }
    .long-text :is(h1,h2,h3) { color: #667eea; margin: 0.5rem 0; }
    .long-text p { margin: 0.6rem 0; }
    .long-text ul, .long-text ol { margin: 0.6rem 0 0.6rem 1.5rem; }
    .detail-actions { display: flex; gap: 1rem; margin-top: 1.5rem; flex-wrap: wrap; }
    .btn {
        display: inline-block; padding: 0.7rem 1.5rem; border-radius: 6px; text-decoration: none;
        border: none; cursor: pointer; font-weight: 500; color: #fff;
    }
    .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .btn-secondary { background: #999; }
</style>
<?= $this->endSection() ?>
