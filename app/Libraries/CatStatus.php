<?php

namespace App\Libraries;

/**
 * CatStatus – knihovna pro převod stavu kočky na český popisek.
 *
 * Sjednocuje zobrazení stavu (available/adopted/reserved) napříč celou
 * aplikací do češtiny, a to ve správném rodu podle pohlaví kočky.
 */
class CatStatus
{
    /**
     * Vrátí český popisek stavu kočky ve správném rodu.
     *
     * Co dělá:
     *   Z anglické hodnoty stavu uložené v databázi (available/adopted/reserved)
     *   sestaví český text. Podle pohlaví zvolí mužský (-ý) nebo ženský (-á) tvar
     *   (např. "Dostupný" vs. "Dostupná"). Neznámý stav vrátí beze změny.
     *
     * @param string      $status Stav z databáze: 'available', 'adopted' nebo 'reserved'.
     * @param string|null $gender Pohlaví kočky: 'male' = mužský tvar, jinak ženský.
     *
     * @return string Český popisek stavu (např. "Dostupná", "Adoptovaný", "Rezervovaná").
     */
    public static function label(string $status, ?string $gender = null): string
    {
        $male = (strtolower((string) $gender) === 'male');

        return match ($status) {
            'available' => $male ? 'Dostupný'   : 'Dostupná',
            'adopted'   => $male ? 'Adoptovaný' : 'Adoptovaná',
            'reserved'  => $male ? 'Rezervovaný' : 'Rezervovaná',
            'pending'   => 'Čekající',
            default     => $status,
        };
    }
}
