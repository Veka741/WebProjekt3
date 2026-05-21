<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="about-section">
    <h1>🐱 Vítejte na našem portálu adopce koček!</h1>
    
    <div class="about-content" style="margin-top: 2rem; line-height: 1.8;">
        <h2 style="margin: 1.5rem 0 1rem 0; color: #667eea;">O nás</h2>
        <p>
            Jsme nezisková organizace zaměřená na záchranné koček a jejich umístění do láskavých domovů. 
            Naše mise je jednoduchá - zajistit, aby každá kočka měla příležitost najít svůj nový domov.
        </p>

        <h2 style="margin: 1.5rem 0 1rem 0; color: #667eea;">Co nabízíme?</h2>
        <ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
            <li>✓ Přístup k fotogalerii všech dostupných koček</li>
            <li>✓ Detailní informace o každé kočce (jméno, plemeno, věk)</li>
            <li>✓ Možnost přidat své vlastní kočky k adopci</li>
            <li>✓ Jednoduchou správu vašich inzerátů</li>
            <li>✓ Bezpečné a ověřené kontakty na personál</li>
        </ul>

        <h2 style="margin: 1.5rem 0 1rem 0; color: #667eea;">Jak to funguje?</h2>
        <ol style="margin-left: 1.5rem; margin-bottom: 1rem;">
            <li>Prohlédněte si naši <a href="/gallery" style="color: #667eea;">galerii koček</a></li>
            <li>Pokud chcete přidat novou kočku, jděte do sekce <a href="/manage" style="color: #667eea;">Správa</a></li>
            <li>Vyplňte informace o kočce a nahrajte fotku</li>
            <li>Ostatní mohou vidět váš inzerát a kontaktovat vás</li>
        </ol>

        <div style="background-color: #e8f4f8; padding: 1.5rem; border-radius: 8px; margin-top: 2rem;">
            <h3 style="color: #667eea; margin-bottom: 0.5rem;">💡 Tip pro uživatele</h3>
            <p>Ať jste azyl, útulna nebo soukromá osoba - můžete si vytvořit profil a sdílet své kočky. 
            Čím více detailů poskytnete, tím lépe se budeme moci postarovat o další kočky!</p>
        </div>
    </div>
</div>

<style>
    .about-section {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .about-section h1 {
        color: #667eea;
        margin-bottom: 0.5rem;
        font-size: 2rem;
    }

    .about-content a {
        color: #667eea;
        text-decoration: none;
    }

    .about-content a:hover {
        text-decoration: underline;
    }
</style>
<?= $this->endSection() ?>
