<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?php
$crumbs = ['Domů' => '/', 'Galerie fotek' => isset($catName) && $catName ? '/gallery' : null];
if (isset($catName) && $catName) {
    $crumbs['Kočka ' . $catName] = null;
}
echo (new \App\Libraries\Breadcrumb())->render($crumbs);
?>

<div class="gallery-section">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom:1rem;">
        <h1><?= isset($catName) && $catName ? 'Fotky kočky ' . esc($catName) : 'Galerie fotek koček' ?></h1>
        <?php if (session('user_id')): ?>
            <a href="/gallery/add" class="btn-add">+ Přidat fotku</a>
        <?php endif; ?>
    </div>

    <?php // Agregační funkce COUNT – celkový počet fotek ?>
    <p class="total-info">Celkem fotek: <strong><?= (int) ($total ?? 0) ?></strong></p>

    <?php if (empty($photos)): ?>
        <div class="empty-box">
            <p>Zatím zde nejsou žádné fotky.</p>
        </div>
    <?php else: ?>
        <div class="photos-grid">
            <?php foreach ($photos as $photo): ?>
                <div class="photo-card">
                    <div class="photo-img">
                        <img src="<?= base_url('images/' . $photo['image_path']) ?>"
                             alt="<?= esc($photo['cat_name'] ?? 'Kočka') ?>"
                             onerror="this.parentNode.innerHTML='<div class=&quot;placeholder&quot;>🐱</div>';">
                        <?php if (($photo['cat_status'] ?? '') === 'reserved'): ?>
                            <span class="reserved-badge">✓ Rezervováno</span>
                        <?php endif; ?>
                    </div>
                    <div class="photo-info">
                        <h3><a href="<?= site_url('gallery/detail/' . $photo['cat_id']) ?>" class="cat-link"><?= esc($photo['cat_name'] ?? 'Neznámá kočka') ?></a></h3>
                        <p class="breed"><?= esc($photo['breed'] ?: 'Neznámé plemeno') ?></p>
                        <?php if (!empty($photo['age']) || !empty($photo['gender'])): ?>
                            <p class="details">
                                <?php if (!empty($photo['age'])): ?><span><?= (int) $photo['age'] ?> let</span><?php endif; ?>
                                <?php if (!empty($photo['age']) && !empty($photo['gender'])): ?> • <?php endif; ?>
                                <?php if (!empty($photo['gender'])): ?><span><?= $photo['gender'] === 'male' ? 'Kluk' : 'Holka' ?></span><?php endif; ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($photo['description'])): ?>
                            <div class="cat-description">
                                <p><?= esc($photo['description']) ?></p>
                            </div>
                        <?php endif; ?>

                        <p class="owner">✉ <?= esc($photo['owner_email'] ?? 'Neznámý inzerent') ?></p>
                        <a href="<?= site_url('gallery/detail/' . $photo['cat_id']) ?>" class="detail-link">Číst podrobný popis →</a>
                        <p class="date">Přidáno: <?= esc($photo['created_at'] ?? '') ?></p>
                        <?php if (session('user_id')): ?>
                            <?php if (($photo['cat_status'] ?? '') === 'reserved'): ?>
                                <button type="button" class="btn-reserve" disabled>Rezervováno</button>
                            <?php else: ?>
                                <button type="button" class="btn-reserve"
                                        onclick="openReserveModal('<?= site_url('gallery/reserve/' . $photo['cat_id']) ?>', '<?= esc($photo['cat_name'] ?? 'tuto kočku', 'js') ?>')">
                                    Rezervovat
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (isset($pager)): ?>
            <div class="pager-wrap">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Modální okno pro potvrzení rezervace kočky -->
<div class="modal-overlay" id="reserveModal">
    <div class="modal-box">
        <h3>Rezervovat kočku?</h3>
        <p>Opravdu chcete rezervovat kočku <strong id="reserveModalName"></strong>? Kočka se označí jako rezervovaná.</p>
        <div class="modal-actions">
            <button type="button" class="btn modal-btn-cancel" onclick="closeReserveModal()">Zrušit</button>
            <a href="#" id="reserveModalConfirm" class="btn modal-btn-confirm">Rezervovat</a>
        </div>
    </div>
</div>

<script>
    function openReserveModal(url, name) {
        document.getElementById('reserveModalName').textContent = name;
        document.getElementById('reserveModalConfirm').setAttribute('href', url);
        document.getElementById('reserveModal').classList.add('open');
    }
    function closeReserveModal() {
        document.getElementById('reserveModal').classList.remove('open');
    }
    document.getElementById('reserveModal').addEventListener('click', function (e) {
        if (e.target === this) closeReserveModal();
    });
</script>

<style>
    .gallery-section h1 { color: #667eea; font-size: 2rem; }
    .total-info { color: #555; margin-bottom: 1.5rem; }
    .btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff; padding: 0.7rem 1.4rem; border-radius: 6px; text-decoration: none;
    }
    .btn-add:hover { transform: translateY(-2px); }

    .photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    .photo-card {
        background: #fff; border-radius: 10px; overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s;
        display: flex; flex-direction: column;
    }
    .photo-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.15); }
    .photo-img { position: relative; height: 200px; overflow: hidden; }
    .photo-img img { width: 100%; height: 100%; object-fit: cover; }
    .reserved-badge {
        position: absolute; top: 10px; right: 10px;
        background: rgba(33, 150, 243, 0.95); color: #fff;
        padding: 0.35rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: bold;
    }
    .placeholder {
        width: 100%; height: 200px; display: flex; align-items: center; justify-content: center;
        font-size: 70px; background: linear-gradient(135deg, #9098bd 0%, #856e9c 100%);
    }
    .photo-info { padding: 1rem; flex-grow: 1; display: flex; flex-direction: column; gap: 0.5rem; }
    .photo-info h3 { color: #667eea; font-size: 1.1rem; }
    .photo-info h3 .cat-link { color: #667eea; text-decoration: none; }
    .photo-info h3 .cat-link:hover { text-decoration: underline; }
    .photo-info .detail-link { color: #764ba2; font-weight: 600; font-size: 0.9rem; text-decoration: none; }
    .photo-info .detail-link:hover { text-decoration: underline; }
    .photo-info .breed { color: #764ba2; font-weight: 600; font-size: 0.95rem; }
    .photo-info .details { color: #666; font-size: 0.9rem; }
    .photo-info .cat-description {
        background-color: #f9f9f9; padding: 0.8rem; border-radius: 6px;
        border-left: 3px solid #667eea;
    }
    .photo-info .cat-description p { color: #555; line-height: 1.5; font-size: 0.9rem; }
    .photo-info .owner { color: #667eea; font-size: 0.85rem; word-break: break-all; }
    .photo-info .date { color: #999; font-size: 0.85rem; }
    .btn-reserve {
        margin-top: auto; background: #df4580; color: #fff; border: none; cursor: pointer;
        padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.9rem;
    }
    .btn-reserve:hover { background: #dd0f76; }
    .btn-reserve:disabled { background: #9e9e9e; cursor: default; }

    .empty-box {
        background: #fff; padding: 3rem; border-radius: 10px; text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1); color: #667eea; font-size: 1.2rem;
    }
    .pager-wrap { margin-top: 2rem; display: flex; justify-content: center; }
    .pager-wrap nav ul { list-style: none; display: flex; gap: 0.3rem; }
    .pager-wrap a, .pager-wrap strong {
        display: inline-block; padding: 0.5rem 0.9rem; border-radius: 6px;
        text-decoration: none; background: #fff; color: #667eea;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .pager-wrap .active strong { background: #667eea; color: #fff; }
</style>
<?= $this->endSection() ?>
