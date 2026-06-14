<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 *
 * Vlastní šablona stránkování – tlačítka První / Předchozí / Další / Poslední
 * v češtině místo číslovaných stránek.
 */

// Inicializace „okna" stránek na celý rozsah, aby správně fungovaly
// metody hasNextPage()/getNextPage() (jinak zůstane okno degenerované).
$pager->setSurroundCount($pager->getPageCount());

$current = $pager->getCurrentPageNumber();
$total   = $pager->getPageCount();
?>
<nav aria-label="Stránkování" class="pager-nav">
    <ul class="pagination">
        <li class="<?= $pager->hasPreviousPage() ? '' : 'is-disabled' ?>">
            <?php if ($pager->hasPreviousPage()) : ?>
                <a href="<?= $pager->getFirst() ?>">&laquo; První</a>
            <?php else : ?>
                <span>&laquo; První</span>
            <?php endif ?>
        </li>
        <li class="<?= $pager->hasPreviousPage() ? '' : 'is-disabled' ?>">
            <?php if ($pager->hasPreviousPage()) : ?>
                <a href="<?= $pager->getPreviousPage() ?>" rel="prev">&lsaquo; Předchozí</a>
            <?php else : ?>
                <span>&lsaquo; Předchozí</span>
            <?php endif ?>
        </li>

        <li class="page-info">
            <span>Stránka <?= $current ?> z <?= $total ?></span>
        </li>

        <li class="<?= $pager->hasNextPage() ? '' : 'is-disabled' ?>">
            <?php if ($pager->hasNextPage()) : ?>
                <a href="<?= $pager->getNextPage() ?>" rel="next">Další &rsaquo;</a>
            <?php else : ?>
                <span>Další &rsaquo;</span>
            <?php endif ?>
        </li>
        <li class="<?= $pager->hasNextPage() ? '' : 'is-disabled' ?>">
            <?php if ($pager->hasNextPage()) : ?>
                <a href="<?= $pager->getLast() ?>">Poslední &raquo;</a>
            <?php else : ?>
                <span>Poslední &raquo;</span>
            <?php endif ?>
        </li>
    </ul>
</nav>
