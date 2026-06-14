<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<section class="hero">
    <div class="hero-text">
        <p class="eyebrow">Útulek &amp; adopce koček</p>
        <h1>Každá kočka si zaslouží<br>svůj domov.</h1>
        <p class="lead">Procházejte naše kočičky, které hledají nový domov, přečtěte si jejich příběhy a najděte si toho svého parťáka na dlouhá léta.</p>
        <div class="hero-actions">
            <a href="/gallery" class="btn btn-fill">Prohlédnout kočky</a>
            <a href="/success" class="btn btn-ghost">Úspěšné adopce</a>
        </div>
    </div>
    <div class="hero-stats">
        <div class="stat">
            <span class="num"><?= (int) ($counts['available'] ?? 0) ?></span>
            <span class="lbl">koček čeká na domov</span>
        </div>
        <div class="stat">
            <span class="num"><?= (int) ($counts['adopted'] ?? 0) ?></span>
            <span class="lbl">už našlo domov</span>
        </div>
    </div>
</section>

<?php if (!empty($featured)): ?>
<section class="block">
    <div class="block-head">
        <h2>Kočky k adopci</h2>
        <a href="/gallery" class="more">Zobrazit všechny &rarr;</a>
    </div>
    <div class="cards">
        <?php foreach ($featured as $cat): ?>
            <article class="card">
                <div class="card-img">
                    <?php if (!empty($cat['photo'])): ?>
                        <img src="<?= base_url('images/' . $cat['photo']) ?>" alt="<?= esc($cat['name']) ?>"
                             onerror="this.parentNode.classList.add('noimg');this.remove();">
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h3><?= esc($cat['name']) ?></h3>
                    <p class="meta"><?= esc($cat['breed'] ?: 'Neznámé plemeno') ?> &middot; <?= (int) $cat['age'] ?> let &middot; <?= $cat['gender'] === 'male' ? 'kluk' : 'holka' ?></p>
                    <?php if (!empty($cat['description'])): ?>
                        <p class="desc"><?= esc(mb_substr($cat['description'], 0, 110)) ?>…</p>
                    <?php endif; ?>
                    <a href="/gallery/detail/<?= $cat['id'] ?>" class="card-link">Více o kočce &rarr;</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<section class="block">
    <h2>Jak adopce probíhá</h2>
    <div class="steps">
        <div class="step"><span class="step-no">1</span><p>Projděte si galerii koček, které u nás zrovna hledají domov.</p></div>
        <div class="step"><span class="step-no">2</span><p>U každé kočky si přečtete povahu, věk, plemeno a celý příběh.</p></div>
        <div class="step"><span class="step-no">3</span><p>Vyberete si tu svou a domluvíte se na osobním seznámení.</p></div>
        <div class="step"><span class="step-no">4</span><p>Když si sednete, kočka jede domů a nám přibyde další šťastný příběh.</p></div>
    </div>
</section>

<style>
    /* ---- Hero ---- */
    .hero {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 2rem;
        align-items: center;
        background: var(--green);
        color: #f4efe4;
        border-radius: 14px;
        padding: 2.6rem 2.4rem;
        margin-bottom: 3rem;
        box-shadow: 0 10px 30px rgba(36,63,53,.18);
    }
    .hero .eyebrow {
        text-transform: uppercase; letter-spacing: 2px; font-size: .8rem;
        color: #e7c3b4; font-weight: 700; margin-bottom: .6rem;
    }
    .hero h1 { color: #fff; font-size: 2.9rem; line-height: 1.08; margin-bottom: 1rem; }
    .hero .lead { color: #dfe7df; font-size: 1.1rem; max-width: 36rem; margin-bottom: 1.6rem; }
    .hero-actions { display: flex; gap: .9rem; flex-wrap: wrap; }
    .btn {
        display: inline-block; padding: .8rem 1.5rem; border-radius: 8px;
        font-weight: 700; text-decoration: none; font-size: 1rem; transition: transform .12s, background-color .15s;
    }
    .btn-fill { background: var(--terra); color: #fff; }
    .btn-fill:hover { background: var(--terra-dark); transform: translateY(-2px); }
    .btn-ghost { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,.55); }
    .btn-ghost:hover { border-color: #fff; transform: translateY(-2px); }

    .hero-stats { display: flex; flex-direction: column; gap: 1rem; }
    .hero-stats .stat {
        background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.18);
        border-radius: 10px; padding: 1.1rem 1.3rem; text-align: center;
    }
    .hero-stats .num { display: block; font-family: 'Fraunces', serif; font-size: 2.4rem; color: #fff; font-weight: 600; }
    .hero-stats .lbl { color: #d8e0d8; font-size: .95rem; }

    /* ---- Blocks ---- */
    .block { margin-bottom: 3rem; }
    .block-head { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 1.4rem; }
    .block h2 { font-size: 1.9rem; margin-bottom: 1.4rem; }
    .block-head h2 { margin-bottom: 0; }
    .block-head .more { color: var(--terra-dark); text-decoration: none; font-weight: 700; }
    .block-head .more:hover { text-decoration: underline; }

    .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.6rem; }
    .card {
        background: var(--card); border: 1px solid var(--line); border-radius: 12px; overflow: hidden;
        display: flex; flex-direction: column; transition: transform .15s, box-shadow .15s;
    }
    .card:hover { transform: translateY(-4px); box-shadow: 0 12px 26px rgba(36,63,53,.14); }
    .card-img { height: 210px; background: #e9e3d4; }
    .card-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .card-img.noimg { background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); }
    .card-body { padding: 1.2rem 1.3rem 1.4rem; display: flex; flex-direction: column; gap: .5rem; flex-grow: 1; }
    .card-body h3 { font-size: 1.4rem; }
    .card-body .meta { color: var(--muted); font-size: .92rem; }
    .card-body .desc { color: #4f4a40; font-size: .95rem; }
    .card-link { margin-top: auto; color: var(--terra-dark); font-weight: 700; text-decoration: none; }
    .card-link:hover { text-decoration: underline; }

    /* ---- Steps ---- */
    .steps { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.2rem; }
    .step {
        background: var(--card); border: 1px solid var(--line); border-radius: 12px; padding: 1.4rem;
    }
    .step-no {
        display: inline-flex; align-items: center; justify-content: center;
        width: 2.3rem; height: 2.3rem; border-radius: 50%;
        background: var(--green); color: #fff; font-family: 'Fraunces', serif; font-weight: 600; font-size: 1.2rem;
        margin-bottom: .8rem;
    }
    .step p { color: #4f4a40; }

    @media (max-width: 900px) {
        .hero { grid-template-columns: 1fr; }
        .hero h1 { font-size: 2.3rem; }
        .cards { grid-template-columns: 1fr 1fr; }
        .steps { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 560px) {
        .cards, .steps { grid-template-columns: 1fr; }
        .hero { padding: 2rem 1.5rem; }
    }
</style>
<?= $this->endSection() ?>
