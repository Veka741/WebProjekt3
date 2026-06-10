<?php

namespace App\Libraries;

use App\Models\Photo;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Gallery as GalleryConfig;

/**
 * ImageUploader – knihovna pro nahrávání obrázků koček.
 *
 * Sdružuje veškerou logiku okolo nahrání souboru (validace, přesun na disk,
 * uložení záznamu do tabulky `photos`), aby se tato operace neopakovala
 * v jednotlivých controllerech (Manage, Gallery).
 */
class ImageUploader
{
    /** @var Photo Model tabulky photos. */
    protected Photo $photoModel;

    /** @var GalleryConfig Konfigurace (povolené přípony, max. velikost, cílová složka). */
    protected GalleryConfig $config;

    /** @var string Text poslední chyby, pokud nahrání selhalo. */
    protected string $error = '';

    public function __construct()
    {
        $this->photoModel = new Photo();
        $this->config     = config('Gallery');
    }

    /**
     * Nahraje a uloží jeden obrázek ke konkrétní kočce.
     *
     * Co dělá:
     *   1) ověří, že soubor je validní a dosud nepřesunutý,
     *   2) zkontroluje příponu a velikost podle konfigurace,
     *   3) přesune soubor do cílové složky pod náhodným názvem,
     *   4) vloží nový záznam do tabulky `photos` (cat_id, image_path, created_at).
     *
     * @param UploadedFile|null $file  Nahraný soubor z $this->request->getFile('...').
     * @param int               $catId ID kočky, ke které obrázek patří.
     *
     * @return int|null ID nově vytvořeného záznamu v `photos`, nebo null při chybě
     *                  (důvod chyby lze získat metodou getError()).
     */
    public function save(?UploadedFile $file, int $catId): ?int
    {
        $this->error = '';

        if ($file === null || ! $file->isValid() || $file->hasMoved()) {
            $this->error = $file ? $file->getErrorString() : 'Nebyl vybrán žádný soubor.';
            return null;
        }

        if (! in_array(strtolower($file->getExtension()), $this->config->allowedExtensions, true)) {
            $this->error = 'Nepovolený typ souboru. Povolené: '
                . implode(', ', $this->config->allowedExtensions) . '.';
            return null;
        }

        if ($file->getSize() > $this->config->maxFileSize) {
            $this->error = 'Soubor je příliš velký (max. '
                . round($this->config->maxFileSize / 1048576, 1) . ' MB).';
            return null;
        }

        $targetDir = rtrim(ROOTPATH, '/\\') . DIRECTORY_SEPARATOR . $this->config->uploadDir;
        $newName   = $file->getRandomName();

        if (! $file->move($targetDir, $newName)) {
            $this->error = 'Soubor se nepodařilo uložit na disk.';
            return null;
        }

        $photoId = $this->photoModel->insert([
            'cat_id'     => $catId,
            'image_path' => $newName,
            'created_at' => date('Y-m-d H:i:s'),
        ], true);

        if (! $photoId) {
            $this->error = 'Záznam o fotce se nepodařilo uložit do databáze.';
            return null;
        }

        return (int) $photoId;
    }

    /**
     * Vrátí text poslední chyby vzniklé při nahrávání.
     *
     * @return string Popis poslední chyby (prázdný řetězec, pokud žádná nenastala).
     */
    public function getError(): string
    {
        return $this->error;
    }
}
