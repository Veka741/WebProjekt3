<?php

namespace App\Libraries;

/**
 * CatStatus – knihovna pro převod stavu kočky na český popisek.
 *
 * Sjednocuje zobrazení stavu (available/reserved/adopted) napříč celou
 * aplikací do češtiny. Protože podstatné jméno „kočka" je rodu ženského,
 * popisky jsou vždy v ženském tvaru.
 */
class CatStatus
{
    /**
     * Vrátí český popisek stavu kočky.
     *
     * Co dělá:
     *   Z anglické hodnoty stavu uložené v databázi sestaví český text
     *   ("available" → "Dostupná k adopci", "reserved" → "Rezervovaná",
     *   "adopted" → "Adoptovaná"). Neznámý stav vrátí beze změny.
     *
     * @param string $status Stav z databáze: 'available', 'reserved' nebo 'adopted'.
     *
     * @return string Český popisek stavu.
     */
    public static function label(string $status): string
    {
        return match ($status) {
            'available' => 'Dostupná k adopci',
            'reserved'  => 'Rezervovaná',
            'adopted'   => 'Adoptovaná',
            default     => $status,
        };
    }
}
