<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Konfigurace galerie fotek.
 *
 * Tento konfigurační soubor řídí chování stránky s fotkami (galerie).
 * Hodnoty lze přepsat v souboru .env pomocí prefixu "gallery."
 * (např. gallery.perPage = 8).
 */
class Gallery extends BaseConfig
{
    /**
     * Počet fotek (karet) zobrazených na jedné stránce při stránkování.
     * Tuto hodnotu čte controller Gallery při volání metody paginate().
     */
    public int $perPage = 12;

    /**
     * Maximální povolená velikost nahrávaného obrázku v bajtech (výchozí 2 MB).
     */
    public int $maxFileSize = 2097152;

    /**
     * Povolené přípony nahrávaných obrázků.
     *
     * @var list<string>
     */
    public array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * Cesta (relativně ke kořeni projektu), kam se ukládají nahrané obrázky.
     */
    public string $uploadDir = 'images';
}
