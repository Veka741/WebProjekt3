<?php

namespace App\Controllers;

use App\Models\Cat;
use App\Models\User;

class Manage extends BaseController
{
    protected $catModel;
    protected $userModel;

    public function __construct()
    {
        $this->catModel = new Cat();
        $this->userModel = new User();
    }

    /**
     * Zobrazí seznam koček aktuálního uživatele
     * Používá stránkování konfigurované v Config/Pagination.php
     */
    public function index()
    {
        $page = $this->request->getVar('page') ?? 1;
        $perPage = config('Pagination')->perPage; // Defaultně 12
        $offset = ($page - 1) * $perPage;

        // Načte pouze kočky přihlášeného uživatele
        $cats = $this->catModel
            ->where('deleted_at', null)
            ->where('user_id', session()->get('user_id'))
            ->limit($perPage, $offset)
            ->findAll();

        // Počet celkových záznamů pro stránkování
        $totalCats = $this->catModel
            ->where('deleted_at', null)
            ->where('user_id', session()->get('user_id'))
            ->countAllResults();

        $pager = service('pager');
        $pager->makeLinks($page, $perPage, $totalCats);

        $data = [
            'title' => 'Správa koček - Portál adopce',
            'cats' => $cats,
            'pager' => $pager,
        ];
        return view('manage', $data);
    }

    /**
     * Přidá novou kočku s fotkou a popisem
     * - Validuje vstupní data
     * - Zpracovává upload fotky
     * - Ukládá HTML z WYSIWYG editoru
     */
    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[2]|max_length[100]',
                'breed' => 'required|min_length[2]|max_length[100]',
                'age' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[50]',
                'gender' => 'required|in_list[male,female]',
                'photo' => 'uploaded[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[photo,2048]',
                'description' => 'required|min_length[10]',
            ];

            if (!$this->validate($rules)) {
                return view('manage_add', [
                    'title' => 'Přidat novou kočku',
                    'users' => $this->userModel->where('deleted_at', null)->findAll(),
                    'errors' => $this->validator->getErrors()
                ]);
            }

            // Zpracování fotky
            $photo = $this->request->getFile('photo');
            $photoName = null;

            if ($photo && $photo->isValid()) {
                $newName = $photo->getRandomName();
                $photo->move('uploads', $newName);
                $photoName = $newName;
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'breed' => $this->request->getPost('breed'),
                'age' => $this->request->getPost('age'),
                'gender' => $this->request->getPost('gender'),
                'description' => $this->request->getPost('description'), // Již obsahuje HTML z TinyMCE
                'photo' => $photoName,
                'user_id' => session()->get('user_id'),
                'status' => 'available',
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if ($this->catModel->insert($data)) {
                session()->setFlashdata('success', 'Kočka byla úspěšně přidána!');
                return redirect()->to('/manage');
            } else {
                session()->setFlashdata('error', 'Chyba při přidávání kočky!');
            }
        }

        $data = [
            'title' => 'Přidat novou kočku',
            'users' => $this->userModel->where('deleted_at', null)->findAll(),
            'errors' => []
        ];
        return view('manage_add', $data);
    }

    /**
     * Edituje existující kočku
     * - Ověřuje vlastnictví
     * - Aktualizuje fotku (smaže starou)
     * - Ukládá HTML z WYSIWYG editoru
     *
     * @param int $id ID kočky
     */
    public function edit($id)
    {
        $cat = $this->catModel->find($id);
        if (!$cat || $cat['user_id'] != session()->get('user_id')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kočka nenalezena nebo nemáte právo ji editovat');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[2]|max_length[100]',
                'breed' => 'required|min_length[2]|max_length[100]',
                'age' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[50]',
                'gender' => 'required|in_list[male,female]',
                'photo' => 'if_exist|uploaded[photo]|mime_in[photo,image/jpg,image/jpeg,image/gif,image/png]|max_size[photo,2048]',
                'description' => 'required|min_length[10]',
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
                'breed' => $this->request->getPost('breed'),
                'age' => $this->request->getPost('age'),
                'gender' => $this->request->getPost('gender'),
                'description' => $this->request->getPost('description'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            // Zpracování nové fotky
            $photo = $this->request->getFile('photo');
            if ($photo && $photo->isValid()) {
                // Smazání staré fotky
                if ($cat['photo'] && file_exists('uploads/' . $cat['photo'])) {
                    unlink('uploads/' . $cat['photo']);
                }
                $newName = $photo->getRandomName();
                $photo->move('uploads', $newName);
                $updateData['photo'] = $newName;
            }

            if ($this->catModel->update($id, $updateData)) {
                session()->setFlashdata('success', 'Kočka byla úspěšně aktualizována!');
                return redirect()->to('/manage');
            } else {
                session()->setFlashdata('error', 'Chyba při aktualizaci kočky!');
            }
        }

        $data = [
            'title' => 'Editace kočky',
            'cat' => $cat,
            'errors' => []
        ];
        return view('manage_edit', $data);
    }

    /**
     * Maže (softdelete) kočku
     * - Nastavuje deleted_at na aktuální čas
     * - Fotka zůstává v úložišti (lze obnovit)
     *
     * @param int $id ID kočky
     */
    public function delete($id)
    {
        $cat = $this->catModel->find($id);
        if (!$cat || $cat['user_id'] != session()->get('user_id')) {
            session()->setFlashdata('error', 'Nemáte právo smazat tuto kočku!');
            return redirect()->to('/manage');
        }

        if ($this->catModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')])) {
            session()->setFlashdata('success', 'Kočka byla úspěšně smazána!');
        } else {
            session()->setFlashdata('error', 'Chyba při mazání kočky!');
        }
        return redirect()->to('/manage');
    }

    /**
     * Označit kočku jako adoptovanou
     * - Změní status na "adopted"
     * - Nastaví adopted_at na aktuální čas
     *
     * @param int $id ID kočky
     */
    public function adopt($id)
    {
        $cat = $this->catModel->find($id);
        if (!$cat || $cat['user_id'] != session()->get('user_id')) {
            session()->setFlashdata('error', 'Nemáte právo aktualizovat tuto kočku!');
            return redirect()->to('/manage');
        }

        if ($this->catModel->update($id, [
            'status' => 'adopted',
            'adopted_at' => date('Y-m-d H:i:s')
        ])) {
            session()->setFlashdata('success', 'Kočka byla označena jako adoptovaná!');
        } else {
            session()->setFlashdata('error', 'Chyba při označení adopce!');
        }
        return redirect()->to('/manage');
    }
}

