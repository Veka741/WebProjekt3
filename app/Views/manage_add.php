<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- Breadcrumbs -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color: rgba(102, 126, 234, 0.1); padding: 0.75rem 1rem; border-radius: 5px; margin-bottom: 2rem;">
        <li class="breadcrumb-item"><a href="/">Domů</a></li>
        <li class="breadcrumb-item"><a href="/manage">Moje inzeráty</a></li>
        <li class="breadcrumb-item active">Přidat nový</li>
    </ol>
</nav>

<div class="form-section">
    <h1>➕ Přidat novou kočku</h1>

    <?php if (!empty($errors ?? [])): ?>
        <div class="alert alert-error show" style="margin-bottom: 2rem;">
            <strong>Chyby ve formuláři:</strong>
            <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                <?php foreach ($errors ?? [] as $error): ?>
                    <li><error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" class="cat-form" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label for="name">Jméno kočky *</label>
            <input type="text" id="name" name="name" value="<?= old('name') ?>" required>
            <small>Minimálně 2 znaky</small>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="breed">Plemeno *</label>
                <input type="text" id="breed" name="breed" value="<?= old('breed') ?>" required>
            </div>

            <div class="form-group">
                <label for="age">Věk (roky) *</label>
                <input type="number" id="age" name="age" value="<?= old('age') ?>" min="0" max="50" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="gender">Pohlaví *</label>
                <select id="gender" name="gender" required>
                    <option value="">-- Vyberte --</option>
                    <option value="male" <?= old('gender') === 'male' ? 'selected' : '' ?>>Samec</option>
                    <option value="female" <?= old('gender') === 'female' ? 'selected' : '' ?>>Samice</option>
                </select>
            </div>

            <div class="form-group">
                <label for="photo">Fotka kočky *</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
                <small>Max. 2MB (JPG, PNG, GIF)</small>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Detailní popis kočky *</label>
            <textarea id="description" name="description" rows="8"><?= old('description') ?></textarea>
            <small>Popište temperament, zvyky, zdravotní stav a zvláštnosti kočky</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-large">✓ Přidat kočku</button>
            <a href="/manage" class="btn btn-secondary btn-large">← Zpět</a>
        </div>
    </form>
</div>

<!-- TinyMCE WYSIWYG Editor -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#description',
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor',
        'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media', 
        'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    language: 'cs',
    height: 400,
    menubar: false,
    branding: false,
    promotion: false
});
</script>

<style>
    .form-section {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-section h1 {
        color: #667eea;
        margin-bottom: 2rem;
        font-size: 2rem;
    }

    .cat-form {
        display: flex;
        flex-direction: column;
    }

    .form-group {
        margin-bottom: 1.5rem;
        display: flex;
        flex-direction: column;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    label {
        font-weight: bold;
        color: #333;
        margin-bottom: 0.5rem;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea,
    select {
        padding: 0.7rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-family: inherit;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="file"]:focus,
    textarea:focus,
    select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
    }

    input[type="file"] {
        padding: 0.5rem;
        cursor: pointer;
    }

    textarea {
        resize: vertical;
        min-height: 150px;
    }

    small {
        font-size: 0.85rem;
        color: #999;
        margin-top: 0.3rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.8rem 1.5rem;
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

    .btn-secondary {
        background-color: #999;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #777;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
        padding: 1rem;
        border-radius: 5px;
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-section {
            padding: 1rem;
        }
    }

    /* Breadcrumbs styling */
    .breadcrumb {
        background-color: rgba(102, 126, 234, 0.1);
        padding: 0.75rem 1rem;
        border-radius: 5px;
        margin-bottom: 2rem;
    }

    .breadcrumb-item a {
        color: #667eea;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #666;
    }
</style>
<?= $this->endSection() ?>
