<?php

namespace App\Libraries;

/**
 * Breadcrumb – knihovna pro vykreslení drobečkové navigace.
 *
 * Umožňuje sestavit jednotnou drobečkovou navigaci na všech stránkách,
 * aniž by se HTML kód musel kopírovat do jednotlivých view souborů.
 */
class Breadcrumb
{
    /**
     * Vykreslí drobečkovou navigaci (breadcrumbs) jako HTML.
     *
     * Co dělá:
     *   Z pole položek sestaví prvek <nav><ol> … </ol></nav>. Každá položka
     *   s neprázdnou URL je odkaz; poslední položka (nebo položka bez URL) je
     *   vykreslena jako neaktivní (aktuální stránka).
     *
     * @param array<string,string|null> $items Asociativní pole 'Popisek' => 'URL'
     *                                          (URL může být null/'' pro aktivní položku).
     *
     * @return string HTML kód drobečkové navigace připravený k vypsání ve view.
     */
    public function render(array $items): string
    {
        if ($items === []) {
            return '';
        }

        $lastIndex = count($items) - 1;
        $i         = 0;
        $li        = '';

        foreach ($items as $label => $url) {
            $isActive = ($i === $lastIndex) || $url === null || $url === '';
            $label    = esc($label);

            if ($isActive) {
                $li .= '<li class="breadcrumb-item active" aria-current="page">' . $label . '</li>';
            } else {
                $li .= '<li class="breadcrumb-item"><a href="' . esc(site_url($url), 'attr') . '">'
                    . $label . '</a></li>';
            }
            $i++;
        }

        return '<nav aria-label="breadcrumb"><ol class="breadcrumb">' . $li . '</ol></nav>';
    }
}
