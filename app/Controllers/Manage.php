<?php

namespace App\Controllers;

use App\Models\Cat;
use App\Models\Breed;
use App\Libraries\ImageUploader;

/**
 * Manage – správa inzerátů koček (CRUD).
 *
 * Veškerá těžká logika (sdílený JOIN dotaz, nahrávání obrázku, vazba na plemeno)
 * je vyčleněna do modelu App\Models\Cat a knihovny App\Libraries\ImageUploader,
 * aby controller zůstal malý a bez opakování kódu.
 */
class Manage extends BaseController
{
    protected Cat $catModel;
    protected Breed $breedModel;

    public function __construct()
    {
        $this->catModel   = new Cat();
        $this->breedModel = new Breed();
    }

    /**
     * Zobrazí seznam všech dostupných koček (bez smazaných) i s fotkou a plemeny.
     */
    public function index()
    {
        return view('manage', [
            'title'  => 'Správa koček - Portál adopce',
            'cats'   => $this->catModel->getCatsWithDetails(),
            'counts' => $this->catModel->countByStatus(),
        ]);
    }

    /**
     * Přidá novou kočku (včetně plemene z dropdownu a nahrané fotky).
     */
    public function add()
    {
        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name'             => 'required|min_length[2]|max_length[255]',
                'breed_id'         => 'required|is_natural_no_zero',
                'age'              => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[50]',
                'gender'           => 'required|in_list[male,female]',
                'long_description' => 'required|min_length[10]',
                'photo'            => 'uploaded[photo]|is_image[photo]|max_size[photo,2048]',
            ];

            if (! $this->validate($rules)) {
                return view('manage_add', [
                    'title'  => 'Přidat novou kočku',
                    'breeds' => $this->breedModel->orderBy('name')->findAll(),
                    'errors' => $this->validator->getErrors(),
                ]);
            }

            $longDescription = $this->request->getPost('long_description');

            $catId = $this->catModel->insert([
                'name'             => $this->request->getPost('name'),
                'age'              => $this->request->getPost('age'),
                'gender'           => $this->request->getPost('gender'),
                'description'      => strip_tags($longDescription),
                'long_description' => $longDescription,
                'status'           => 'available',
                'user_id'          => session('user_id'),
            ], true);

            if ($catId) {
                // Vazba na vybrané plemeno + uložení nahrané fotky
                $this->catModel->setBreed((int) $catId, (int) $this->request->getPost('breed_id'));

                $uploader = new ImageUploader();
                if ($uploader->save($this->request->getFile('photo'), (int) $catId) === null) {
                    session()->setFlashdata('error', 'Kočka uložena, ale fotku se nepodařilo nahrát: ' . $uploader->getError());
                } else {
                    session()->setFlashdata('success', 'Kočka byla úspěšně přidána!');
                }
                return redirect()->to('/manage');
            }

            session()->setFlashdata('error', 'Chyba při přidávání kočky!');
        }

        return view('manage_add', [
            'title'  => 'Přidat novou kočku',
            'breeds' => $this->breedModel->orderBy('name')->findAll(),
            'errors' => [],
        ]);
    }

    /**
     * Edituje existující kočku (včetně plemene a dlouhého popisu z WYSIWYG).
     */
    public function edit($id)
    {
        $cat = $this->catModel->find($id);
        if (! $cat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kočka nenalezena');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'name'             => 'required|min_length[2]|max_length[255]',
                'breed_id'         => 'required|is_natural_no_zero',
                'age'              => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[50]',
                'gender'           => 'required|in_list[male,female]',
                'long_description' => 'required|min_length[10]',
            ];

            if (! $this->validate($rules)) {
                return view('manage_edit', [
                    'title'           => 'Editace kočky',
                    'cat'             => $cat,
                    'breeds'          => $this->breedModel->orderBy('name')->findAll(),
                    'selectedBreedId' => $this->catModel->getBreedId((int) $id),
                    'errors'          => $this->validator->getErrors(),
                ]);
            }

            $longDescription = $this->request->getPost('long_description');

            $this->catModel->update($id, [
                'name'             => $this->request->getPost('name'),
                'age'              => $this->request->getPost('age'),
                'gender'           => $this->request->getPost('gender'),
                'description'      => strip_tags($longDescription),
                'long_description' => $longDescription,
            ]);
            $this->catModel->setBreed((int) $id, (int) $this->request->getPost('breed_id'));

            session()->setFlashdata('success', 'Kočka byla aktualizována!');
            return redirect()->to('/manage');
        }

        return view('manage_edit', [
            'title'           => 'Editace kočky',
            'cat'             => $cat,
            'breeds'          => $this->breedModel->orderBy('name')->findAll(),
            'selectedBreedId' => $this->catModel->getBreedId((int) $id),
            'errors'          => [],
        ]);
    }

    /**
     * Softdelete – archivuje kočku (uloží datum a čas do deleted_at).
     */
    public function softDelete($id)
    {
        if (! $this->catModel->find($id)) {
            session()->setFlashdata('error', 'Kočka nenalezena');
            return redirect()->to('/manage');
        }

        if ($this->catModel->delete($id)) {
            session()->setFlashdata('success', 'Kočka byla archivována!');
        } else {
            session()->setFlashdata('error', 'Chyba při archivaci');
        }

        return redirect()->to('/manage');
    }

    /**
     * Označí kočku jako adoptovanou.
     */
    public function adopt($id)
    {
        if (! $this->catModel->find($id)) {
            session()->setFlashdata('error', 'Kočka nenalezena');
            return redirect()->to('/manage');
        }

        if ($this->catModel->update($id, ['status' => 'adopted'])) {
            session()->setFlashdata('success', 'Kočka byla označena jako adoptovaná!');
        } else {
            session()->setFlashdata('error', 'Chyba při označení adopce');
        }

        return redirect()->to('/manage');
    }
}
