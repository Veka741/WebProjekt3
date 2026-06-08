
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="admin-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h1>Správa uživatelů</h1>
        <a href="/admin/users/add" class="btn btn-primary">+ Přidat nového uživatele</a>
    </div>

    <!-- Aktivní uživatelé -->
    <div class="section-box">
        <h2>✓ Aktivní uživatelé (<?= count($activeUsers) ?>)</h2>
        
        <?php if (empty($activeUsers)): ?>
            <p style="text-align: center; color: #999; padding: 2rem;">Žádní aktivní uživatelé</p>
        <?php else: ?>
            <div class="users-table">
                <div class="table-header">
                    <div class="col-name">Jméno</div>
                    <div class="col-email">Email</div>
                    <div class="col-phone">Telefon</div>
                    <div class="col-type">Typ</div>
                    <div class="col-city">Město</div>
                    <div class="col-actions">Akce</div>
                </div>

                <?php foreach ($activeUsers as $user): ?>
                    <div class="table-row">
                        <div class="col-name">
                            <strong><?= $user['name'] ?></strong>
                        </div>
                        <div class="col-email"><?= $user['email'] ?></div>
                        <div class="col-phone"><?= $user['phone'] ?></div>
                        <div class="col-type">
                            <span class="badge badge-<?= $user['type'] === 'individual' ? 'blue' : 'green' ?>">
                                <?= $user['type'] === 'individual' ? 'Jednotlivec' : 'Organizace' ?>
                            </span>
                        </div>
                        <div class="col-city"><?= $user['city'] ?></div>
                        <div class="col-actions">
                            <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn-action btn-edit" title="Editovat">editovat</a>
                            <a href="/admin/users/soft-delete/<?= $user['id'] ?>" class="btn-action btn-delete" title="Archivovat" onclick="return confirm('Archivovat tohoto uživatele?');">🗑️</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Archivovaní uživatelé -->
    <?php if (!empty($deletedUsers)): ?>
        <div class="section-box" style="margin-top: 2rem; opacity: 0.8;">
            <h2>Archivovaní uživatelé (<?= count($deletedUsers) ?>)</h2>
            
            <div class="users-table">
                <div class="table-header">
                    <div class="col-name">Jméno</div>
                    <div class="col-email">Email</div>
                    <div class="col-phone">Telefon</div>
                    <div class="col-type">Typ</div>
                    <div class="col-city">Město</div>
                    <div class="col-actions">Akce</div>
                </div>

                <?php foreach ($deletedUsers as $user): ?>
                    <div class="table-row deleted">
                        <div class="col-name">
                            <strong><?= $user['name'] ?></strong>
                        </div>
                        <div class="col-email"><?= $user['email'] ?></div>
                        <div class="col-phone"><?= $user['phone'] ?></div>
                        <div class="col-type">
                            <span class="badge badge-<?= $user['type'] === 'individual' ? 'blue' : 'green' ?>">
                                <?= $user['type'] === 'individual' ? 'Jednotlivec' : 'Organizace' ?>
                            </span>
                        </div>
                        <div class="col-city"><?= $user['city'] ?></div>
                        <div class="col-actions">
                            <a href="/admin/users/restore/<?= $user['id'] ?>" class="btn-action btn-restore" title="Obnovit" onclick="return confirm('Obnovit tohoto uživatele?');">↩️</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    .admin-section h1 {
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

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .section-box {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .section-box h2 {
        color: #667eea;
        margin-bottom: 1.5rem;
        font-size: 1.3rem;
        border-bottom: 2px solid #667eea;
        padding-bottom: 0.5rem;
    }

    .users-table {
        overflow-x: auto;
    }

    .table-header {
        display: grid;
        grid-template-columns: 1.5fr 1.5fr 1fr 1fr 1fr 0.8fr;
        gap: 1rem;
        padding: 1rem;
        background-color: #f5f5f5;
        border-radius: 6px;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .table-row {
        display: grid;
        grid-template-columns: 1.5fr 1.5fr 1fr 1fr 1fr 0.8fr;
        gap: 1rem;
        padding: 1rem;
        border-bottom: 1px solid #eee;
        align-items: center;
        transition: background-color 0.2s;
    }

    .table-row:hover {
        background-color: #f9f9f9;
    }

    .table-row.deleted {
        opacity: 0.6;
        background-color: #fafafa;
    }

    .col-name strong {
        color: #333;
    }

    .badge {
        display: inline-block;
        padding: 0.35rem 0.7rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: bold;
        color: white;
    }

    .badge-blue {
        background-color: #2196f3;
    }

    .badge-green {
        background-color: #4caf50;
    }

    .btn-action {
        display: inline-block;
        padding: 0.4rem 0.6rem;
        margin: 0 0.2rem;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .btn-edit {
        background-color: #4caf50;
        color: white;
    }

    .btn-edit:hover {
        background-color: #45a049;
    }

    .btn-delete {
        background-color: #ff9800;
        color: white;
    }

    .btn-delete:hover {
        background-color: #e68900;
    }

    .btn-restore {
        background-color: #2196f3;
        color: white;
    }

    .btn-restore:hover {
        background-color: #0b7dda;
    }

    @media (max-width: 1200px) {
        .table-header,
        .table-row {
            grid-template-columns: 1fr 1fr 0.8fr;
        }

        .col-phone,
        .col-city {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .table-header,
        .table-row {
            grid-template-columns: 1fr 0.6fr;
        }

        .col-email,
        .col-type,
        .col-phone,
        .col-city {
            display: none;
        }

        .col-actions {
            text-align: right;
        }
    }
</style>
<?= $this->endSection() ?>