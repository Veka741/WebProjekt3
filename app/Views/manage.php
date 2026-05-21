<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="manage-section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>📋 Správa inzerátů</h1>
        <a href="/manage/add" class="btn btn-primary">+ Přidat novou kočku</a>
    </div>

    <?php if (empty($cats)): ?>
        <div style="background-color: #f0f0f0; padding: 2rem; border-radius: 8px; text-align: center;">
            <p style="font-size: 1.1rem; color: #666; margin-bottom: 1rem;">Zatím jste nepřidali žádné kočky.</p>
            <a href="/manage/add" class="btn btn-primary">Přidat první kočku</a>
        </div>
    <?php else: ?>
        <div class="cats-table">
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Jméno</th>
                        <th>Plemeno</th>
                        <th>Věk</th>
                        <th>Typ</th>
                        <th>Kontakt</th>
                        <th>Akce</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cats as $cat): ?>
                        <tr>
                            <td>
                                <?php if ($cat['photo']): ?>
                                    <img src="<?= base_url('uploads/' . $cat['photo']) ?>" alt="<?= $cat['name'] ?>" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover;">
                                <?php else: ?>
                                    <span style="font-size: 2rem;">🐱</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $cat['name'] ?></td>
                            <td><?= $cat['breed'] ?></td>
                            <td><?= $cat['age'] ?> let</td>
                            <td><?= ucfirst($cat['user_type']) ?></td>
                            <td><?= $cat['user_name'] ?></td>
                            <td>
                                <a href="/manage/edit/<?= $cat['id'] ?>" class="btn btn-small btn-edit">✏️ Editovat</a>
                                <a href="/manage/delete/<?= $cat['id'] ?>" class="btn btn-small btn-delete" onclick="return confirm('Opravdu chcete smazat tuto kočku?');">🗑️ Smazat</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
        border: none;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .btn-primary {
        background-color: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background-color: #5568d3;
    }

    .btn-small {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
    }

    .btn-edit {
        background-color: #4caf50;
        color: white;
    }

    .btn-edit:hover {
        background-color: #45a049;
    }

    .btn-delete {
        background-color: #f44336;
        color: white;
    }

    .btn-delete:hover {
        background-color: #da190b;
    }

    .cats-table {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead {
        background-color: #f5f5f5;
    }

    table th {
        padding: 1rem;
        text-align: left;
        font-weight: bold;
        color: #667eea;
        border-bottom: 2px solid #667eea;
    }

    table td {
        padding: 1rem;
        border-bottom: 1px solid #eee;
    }

    table tbody tr:hover {
        background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
        table {
            font-size: 0.9rem;
        }

        table th, table td {
            padding: 0.7rem;
        }
    }
</style>
<?= $this->endSection() ?>
