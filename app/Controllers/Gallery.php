<?php

namespace App\Controllers;

use App\Models\Cat;
use App\Models\Photo;
use App\Libraries\ImageUploader;

/**
 * Gallery – galerie fotek koček.
 *
 * Zobrazuje tabulku `photos` do karet se stránkováním, jehož velikost se načítá
 * z konfiguračního souboru app/Config/Gallery.php. Umožňuje (přihlášeným
 * uživatelům) přidávat a mazat fotky. Mazání je softdelete (ukládá deleted_at).
 */
class Gallery extends BaseController
{
    protected Photo $photoModel;
    protected Cat $catModel;

    public function __construct()
    {
        $this->photoModel = new Photo();
        $this->catModel   = new Cat();
    }

    /**
     * Výpis všech fotek do karet se stránkováním (velikost stránky z configu).
     */
    public function index()
    {
        $perPage = config('Gallery')->perPage;

        $photos = $this->photoModel
            ->select('photos.*, cats.name AS cat_name, cats.status AS cat_status, cats.description, cats.age, cats.gender, ANY_VALUE(users.email) AS owner_email, GROUP_CONCAT(DISTINCT breeds.name SEPARATOR ", ") AS breed')
            ->join('cats', 'cats.id = photos.cat_id', 'left')
            ->join('cat_breeds', 'cat_breeds.cat_id = cats.id', 'left')
            ->join('breeds', 'breeds.id = cat_breeds.breed_id', 'left')
            ->join('users', 'users.id = cats.user_id', 'left')
            ->where('photos.deleted_at', null)
            ->groupBy('photos.id')
            ->orderBy('photos.created_at', 'DESC')
            ->paginate($perPage);

        return view('gallery', [
            'title'   => 'Galerie fotek - Portál adopce',
            'photos'  => $photos,
            'pager'   => $this->photoModel->pager,
            'total'   => $this->photoModel->where('photos.deleted_at', null)->countAllResults(),
            'catName' => null,
        ]);
    }

    /**
     * Výpis fotek jedné konkrétní kočky se stránkováním.
     *
     * Tato routa využívá DVA parametry: ID kočky a číslo stránky
     * (gallery/cat/(:num)/(:num)).
     *
     * @param int $catId ID kočky, jejíž fotky chceme zobrazit.
     * @param int $page  Číslo stránky stránkování (výchozí 1).
     */
    public function byCat(int $catId, int $page = 1)
    {
        $cat = $this->catModel->find($catId);
        if (! $cat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kočka nenalezena');
        }

        $perPage = config('Gallery')->perPage;

        $photos = $this->photoModel
            ->select('photos.*, cats.name AS cat_name, cats.status AS cat_status, cats.description, cats.age, cats.gender, ANY_VALUE(users.email) AS owner_email, GROUP_CONCAT(DISTINCT breeds.name SEPARATOR ", ") AS breed')
            ->join('cats', 'cats.id = photos.cat_id', 'left')
            ->join('cat_breeds', 'cat_breeds.cat_id = cats.id', 'left')
            ->join('breeds', 'breeds.id = cat_breeds.breed_id', 'left')
            ->join('users', 'users.id = cats.user_id', 'left')
            ->where('photos.cat_id', $catId)
            ->where('photos.deleted_at', null)
            ->groupBy('photos.id')
            ->orderBy('photos.created_at', 'DESC')
            ->paginate($perPage, 'default', $page);

        return view('gallery', [
            'title'   => 'Fotky kočky ' . $cat['name'],
            'photos'  => $photos,
            'pager'   => $this->photoModel->pager,
            'total'   => $this->photoModel->where('photos.cat_id', $catId)->where('photos.deleted_at', null)->countAllResults(),
            'catName' => $cat['name'],
        ]);
    }

    /**
     * Přidání nové fotky (formulář + uložení). Pouze pro přihlášené uživatele.
     */
    public function add()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'cat_id' => 'required|is_natural_no_zero',
                'photo'  => 'uploaded[photo]|is_image[photo]|max_size[photo,2048]',
            ];

            if (! $this->validate($rules)) {
                return view('gallery_add', [
                    'title'  => 'Přidat fotku',
                    'cats'   => $this->catModel->where('deleted_at', null)->orderBy('name')->findAll(),
                    'errors' => $this->validator->getErrors(),
                ]);
            }

            $uploader = new ImageUploader();
            if ($uploader->save($this->request->getFile('photo'), (int) $this->request->getPost('cat_id')) !== null) {
                session()->setFlashdata('success', 'Fotka byla úspěšně přidána!');
            } else {
                session()->setFlashdata('error', 'Chyba při nahrávání fotky: ' . $uploader->getError());
            }
            return redirect()->to('/gallery');
        }

        return view('gallery_add', [
            'title'  => 'Přidat fotku',
            'cats'   => $this->catModel->where('deleted_at', null)->orderBy('name')->findAll(),
            'errors' => [],
        ]);
    }

    /**
     * Softdelete fotky (uloží datum a čas do deleted_at). Pouze pro přihlášené.
     *
     * @param int $id ID fotky.
     */
    public function delete(int $id)
    {
        if (! $this->photoModel->find($id)) {
            session()->setFlashdata('error', 'Fotka nenalezena');
            return redirect()->to('/gallery');
        }

        if ($this->photoModel->delete($id)) {
            session()->setFlashdata('success', 'Fotka byla smazána!');
        } else {
            session()->setFlashdata('error', 'Chyba při mazání fotky');
        }

        return redirect()->to('/gallery');
    }

    /**
     * Rezervuje kočku z galerie – nastaví její stav na "reserved".
     * Pouze pro přihlášené uživatele.
     *
     * @param int $catId ID kočky, kterou chceme rezervovat.
     */
    public function reserve(int $catId)
    {
        $cat = $this->catModel->find($catId);
        if (! $cat) {
            session()->setFlashdata('error', 'Kočka nenalezena');
            return redirect()->to('/gallery');
        }

        if ($this->catModel->update($catId, ['status' => 'reserved'])) {
            session()->setFlashdata('success', 'Kočka byla rezervována!');
        } else {
            session()->setFlashdata('error', 'Chyba při rezervaci');
        }

        return redirect()->to('/gallery');
    }
}
