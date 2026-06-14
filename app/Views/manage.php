
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<?= (new \App\Libraries\Breadcrumb())->render(['Domů' => '/', 'Správa koček' => null]) ?>
<div class="manage-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h1>Správa inzerátů</h1>
        <a href="/manage/add" class="btn btn-primary">+ Přidat novou kočku</a>
    </div>

    <?php // Agregace (COUNT + GROUP BY) – přehled počtu koček podle stavu ?>
    <p style="margin-bottom: 1.5rem; color: #555;">
        Dostupných: <strong><?= (int) ($counts['available'] ?? 0) ?></strong> &nbsp;|&nbsp;
        Adoptovaných: <strong><?= (int) ($counts['adopted'] ?? 0) ?></strong>
    </p>

    <?php if (empty($cats)): ?>
        <div style="background-color: white; padding: 3rem; border-radius: 10px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <p style="font-size: 1.3rem; color: #33665a; margin-bottom: 1.5rem;"> Zatím jste nepřidali žádné kočky.</p>
            <a href="/manage/add" class="btn btn-primary btn-large">Přidat první kočku</a>
        </div>
    <?php else: ?>
        <div class="cats-cards">
            <?php foreach ($cats as $cat): ?>
                <div class="cat-management-card">
                    <div class="card-header">
                        <?php if (!empty($cat['photo'] ?? null)): ?>
                            <img src="<?= base_url('images/'.$cat['photo']) ?>" alt="<?= $cat['name'] ?>">
                        <?php else: ?>
                            <div class="placeholder-image"></div>
                        <?php endif; ?>
                        <div class="status-badge <?= $cat['status'] ?>">
                            <?= esc(\App\Libraries\CatStatus::label($cat['status'])) ?>
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
                            <span><?= $cat['gender'] === 'male' ? 'Kluk' : 'Holka' ?></span>
                        </div>
                        <?php if ($cat['description']): ?>
                            <div class="description-preview">
                                <?= substr($cat['description'], 0, 100) ?>...
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="card-actions">
                        <a href="/manage/detail/<?= $cat['id'] ?>" class="btn btn-small btn-detail">Detail</a>
                        <a href="/manage/edit/<?= $cat['id'] ?>" class="btn btn-small btn-edit">Editovat</a>
                        <?php if ($cat['status'] !== 'adopted'): ?>
                            <a href="/manage/adopt/<?= $cat['id'] ?>" class="btn btn-small btn-adopt" onclick="return confirm('Označit tuto kočku jako adoptovanou?');">Adoptovaná</a>
                        <?php endif; ?>
                        <button type="button" class="btn btn-small btn-archive"
                                onclick="openDeleteModal('<?= site_url('manage/soft-delete/'.$cat['id']) ?>', '<?= esc($cat['name'], 'js') ?>')">Archivovat</button>
                        <?php if (!empty($cat['photo_id'])): ?>
                            <button type="button" class="btn btn-small btn-photo-delete"
                                    onclick="openPhotoModal('<?= site_url('manage/delete-photo/'.$cat['photo_id']) ?>', '<?= esc($cat['name'], 'js') ?>')">Smazat fotku</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modální okno pro potvrzení archivace (mazání) -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <h3>Archivovat kočku?</h3>
        <p>Opravdu chcete archivovat kočku <strong id="deleteModalName"></strong>? Záznam zůstane uložen (softdelete) a lze jej obnovit.</p>
        <div class="modal-actions">
            <button type="button" class="btn modal-btn-cancel" onclick="closeDeleteModal()">Zrušit</button>
            <a href="#" id="deleteModalConfirm" class="btn modal-btn-confirm">Archivovat</a>
        </div>
    </div>
</div>

<!-- Modální okno pro potvrzení smazání fotky -->
<div class="modal-overlay" id="photoModal">
    <div class="modal-box">
        <h3>Smazat fotku?</h3>
        <p>Opravdu chcete smazat fotku kočky <strong id="photoModalName"></strong>? Fotka bude označena jako smazaná (softdelete).</p>
        <div class="modal-actions">
            <button type="button" class="btn modal-btn-cancel" onclick="closePhotoModal()">Zrušit</button>
            <a href="#" id="photoModalConfirm" class="btn modal-btn-confirm">Smazat fotku</a>
        </div>
    </div>
</div>

<script>
    function openDeleteModal(url, name) {
        document.getElementById('deleteModalName').textContent = name;
        document.getElementById('deleteModalConfirm').setAttribute('href', url);
        document.getElementById('deleteModal').classList.add('open');
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('open');
    }
    // Zavření kliknutím mimo okno
    document.getElementById('deleteModal').addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });

    function openPhotoModal(url, name) {
        document.getElementById('photoModalName').textContent = name;
        document.getElementById('photoModalConfirm').setAttribute('href', url);
        document.getElementById('photoModal').classList.add('open');
    }
    function closePhotoModal() {
        document.getElementById('photoModal').classList.remove('open');
    }
    document.getElementById('photoModal').addEventListener('click', function (e) {
        if (e.target === this) closePhotoModal();
    });
</script>

<style>
    .manage-section h1 {
        color: #33665a;
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
        background: linear-gradient(135deg, #33665a 0%, #4a7a6c 100%);
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

    .btn-detail {
        background-color: #33665a;
        color: white;
    }

    .btn-detail:hover {
        background-color: #28534a;
    }

    .btn-edit {
        background-color: #929292ff;
        color: white;
    }

    .btn-edit:hover {
        background-color: #758075ff;
    }

    .btn-adopt {
        background-color: #cf6a4c;
        color: white;
    }

    .btn-adopt:hover {
        background-color: #b9543a;
    }

    .btn-archive {
        background-color: #ff9800;
        color: white;
    }

    .btn-archive:hover {
        background-color: #e68900;
    }

    .btn-photo-delete {
        background-color: #dc3545;
        color: white;
    }

    .btn-photo-delete:hover {
        background-color: #b02a37;
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
        background: linear-gradient(135deg, #6f8f84ff 0%, #22463cff 100%);
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

    .status-badge.reserved {
        background-color: rgba(223, 69, 128, 0.9);
    }

    .status-badge.pending {
        background-color: rgba(255, 152, 0, 0.9);
    }

    .card-body {
        padding: 1.5rem;
        flex-grow: 1;
    }

    .card-body h3 {
        color: #33665a;
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
        border-left: 3px solid #33665a;
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
