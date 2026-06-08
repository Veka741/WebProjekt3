<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="about-section">
    <h1>🐱 Vítejte na našem portálu adopce koček!</h1>
    
    <div class="about-content">
        <h2>O nás</h2>
        <p>
            Jsme komunitní portál zaměřený na hledání milujících domovů pro kozy. 
            Naše mise je spojit láskavcí lidi s jejich budoucími kočičími miláčky.
        </p>

        <h2>Co nabízíme?</h2>
        <ul>
            <li>📋 Rozsáhlý katalog dostupných koček k adopci</li>
            <li>💚 Přehledy úspěšně adoptovaných koček</li>
            <li>👥 Správu profilu majitelů/organizací</li>
            <li>⚙️ Snadné přidávání a spravování inzerátů</li>
        </ul>

        <h2>Jak to funguje?</h2>
        <ol>
            <li>Přihlaste se nebo si vytvořte profil</li>
            <li>Procházejte naši galerii dostupných koček</li>
            <li>Vyberte si kočku, která se vám líbí</li>
            <li>Kontaktujte majitele pro dohodnutí adopce</li>
            <li>Užívejte si nového člena své rodiny!</li>
        </ol>

        <div class="cta-box">
            <h3>Začněte hned!</h3>
            <p>Procházejte naši galerii nebo přidejte vlastní inzerát.</p>
            <div class="cta-buttons">
                <a href="/gallery" class="btn btn-primary">🖼️ Procházet galerii</a>
                <a href="/manage/add" class="btn btn-secondary">➕ Přidat inzerát</a>
            </div>
        </div>
    </div>
</div>

<style>
    .about-section {
        max-width: 900px;
        margin: 0 auto;
    }

    .about-section h1 {
        color: #667eea;
        margin-bottom: 2rem;
        font-size: 2.5rem;
        text-align: center;
    }

    .about-content {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        line-height: 1.8;
    }

    .about-content h2 {
        color: #667eea;
        margin: 1.5rem 0 1rem 0;
        font-size: 1.5rem;
    }

    .about-content p {
        margin-bottom: 1rem;
        color: #555;
    }

    .about-content ul,
    .about-content ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }

    .about-content li {
        margin-bottom: 0.5rem;
        color: #555;
    }

    .cta-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 10px;
        margin-top: 2rem;
        text-align: center;
    }

    .cta-box h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-block;
        padding: 0.8rem 1.5rem;
        border-radius: 6px;
        text-decoration: none;
        cursor: pointer;
        border: none;
        font-size: 1rem;
        transition: all 0.3s;
        font-weight: 500;
    }

    .btn-primary {
        background-color: white;
        color: #667eea;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn-secondary {
        background-color: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid white;
    }

    .btn-secondary:hover {
        background-color: rgba(255,255,255,0.3);
    }

    @media (max-width: 768px) {
        .about-section h1 {
            font-size: 1.8rem;
        }

        .cta-buttons {
            flex-direction: column;
        }
    }
</style>
<?= $this->endSection() ?>
