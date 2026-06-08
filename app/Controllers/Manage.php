<?php

namespace App\Controllers;

use App\Models\Cat;
use App\Models\User;
use App\Models\Photo;
use App\Models\Breed;
use App\Models\CatBreed;

class Manage extends BaseController
{
    protected $catModel;
    protected $userModel;
    protected $photoModel;
    protected $breedModel;
    protected $catBreedModel;

    public function __construct()
    {
        $this->catModel = new Cat();
        $this->userModel = new User();
        $this->photoModel = new Photo();
        $this->breedModel = new Breed();
        $this->catBreedModel = new CatBreed();
    }

    /**
     * Zobrazí seznam všech dostupných koček (bez smazaných)
     */
    public function index()
    {
        $cats = $this->catModel
            ->select('cats.*, ANY_VALUE(photos.image_path) AS photo, GROUP_CONCAT(DISTINCT breeds.name SEPARATOR ", ") AS breed')
            ->join('photos', 'photos.cat_id = cats.id', 'left')
            ->join('cat_breeds', 'cat_breeds.cat_id = cats.id', 'left')
            ->join('breeds', 'breeds.id = cat_breeds.breed_id', 'left')
            ->where('cats.deleted_at', null)
            ->groupBy('cats.id')
            ->orderBy('cats.created_at', 'DESC')
            ->findAll();
    
        $data = [
            'title' => 'Správa koček - Portál adopce',
            'cats' => $cats
        ];
    
        return view('manage', $data);
    }

    /**
     * Přidá novou kočku
     */
    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[2]|max_length[255]',
                'age' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[50]',
                'gender' => 'required|in_list[male,female]',
                'description' => 'required|min_length[10]|max_length[1000]',
            ];

            if (!$this->validate($rules)) {
                return view('manage_add', [
                    'title' => 'Přidat novou kočku',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'age' => $this->request->getPost('age'),
                'gender' => $this->request->getPost('gender'),
                'description' => $this->request->getPost('description'),
                'long_description' => $this->request->getPost('description'),
                'status' => 'available',
            ];

            if ($this->catModel->insert($data)) {
                session()->setFlashdata('success', '✓ Kočka byla úspěšně přidána!');
                return redirect()->to('/manage');
            } else {
                session()->setFlashdata('error', '✗ Chyba při přidávání kočky!');
            }
        }

        return view('manage_add', ['title' => 'Přidat novou kočku', 'errors' => []]);
    }

    /**
     * Edituje existující kočku
     */
    public function edit($id)
    {
        $cat = $this->catModel->find($id);
        if (!$cat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kočka nenalezena');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[2]|max_length[255]',
                'age' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[50]',
                'gender' => 'required|in_list[male,female]',
                'description' => 'required|min_length[10]|max_length[1000]',
            ];

            if (!$this->validate($rules)) {
                return view('manage_edit', [
                    'title' => 'Editace kočky',
                    'cat' => $cat,
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $updateData = [
                'name' => $this->request->getPost('name'),
                'age' => $this->request->getPost('age'),
                'gender' => $this->request->getPost('gender'),
                'description' => $this->request->getPost('description'),
                'long_description' => $this->request->getPost('description'),
            ];

            if ($this->catModel->update($id, $updateData)) {
                session()->setFlashdata('success', '✓ Kočka byla aktualizována!');
                return redirect()->to('/manage');
            }
        }

        return view('manage_edit', [
            'title' => 'Editace kočky',
            'cat' => $cat,
            'errors' => []
        ]);
    }

    /**
     * Softdelete - archivuje kočku
     */
    public function softDelete($id)
    {
        $cat = $this->catModel->find($id);
        if (!$cat) {
            session()->setFlashdata('error', 'Kočka nenalezena');
            return redirect()->to('/manage');
        }

        if ($this->catModel->delete($id)) {
            session()->setFlashdata('success', '✓ Kočka byla archivována!');
        } else {
            session()->setFlashdata('error', '✗ Chyba při archivaci');
        }

        return redirect()->to('/manage');
    }

    /**
     * Označit jako adoptovanou
     */
    public function adopt($id)
    {
        $cat = $this->catModel->find($id);
        if (!$cat) {
            session()->setFlashdata('error', 'Kočka nenalezena');
            return redirect()->to('/manage');
        }

        if ($this->catModel->update($id, ['status' => 'adopted'])) {
            session()->setFlashdata('success', '💚 Kočka byla označena jako adoptovaná!');
        } else {
            session()->setFlashdata('error', '✗ Chyba při označení adopce');
        }

        return redirect()->to('/manage');
    }
}

