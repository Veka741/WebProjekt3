<?php

namespace App\Controllers;

use App\Models\CatModel;

class Manage extends BaseController
{
    protected $catModel;

    public function __construct()
    {
        $this->catModel = new CatModel();
    }

    public function index()
    {
        $cats = $this->catModel->getAllCats();
        $data = [
            'title' => 'Správa inzerátů - Portál adopce',
            'cats' => $cats
        ];
        return view('manage', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $file = $this->request->getFile('photo');
            $photoName = null;

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $photoName = $file->getRandomName();
                $file->move('uploads', $photoName);
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'breed' => $this->request->getPost('breed'),
                'age' => $this->request->getPost('age'),
                'description' => $this->request->getPost('description'),
                'photo' => $photoName,
                'user_name' => $this->request->getPost('user_name'),
                'user_type' => $this->request->getPost('user_type'),
            ];

            if ($this->catModel->insert($data)) {
                session()->setFlashdata('success', 'Kočka byla úspěšně přidána!');
            } else {
                session()->setFlashdata('error', 'Chyba při přidávání koček!');
            }

            return redirect()->to('/manage');
        }

        return view('manage_add');
    }

    public function edit($id)
    {
        $cat = $this->catModel->find($id);
        if (!$cat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kočka nenalezena');
        }

        if ($this->request->getMethod() === 'post') {
            $file = $this->request->getFile('photo');
            $photoName = $cat['photo'];

            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Smazání staré fotky
                if ($photoName && file_exists('uploads/' . $photoName)) {
                    unlink('uploads/' . $photoName);
                }
                $photoName = $file->getRandomName();
                $file->move('uploads', $photoName);
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'breed' => $this->request->getPost('breed'),
                'age' => $this->request->getPost('age'),
                'description' => $this->request->getPost('description'),
                'photo' => $photoName,
                'user_name' => $this->request->getPost('user_name'),
                'user_type' => $this->request->getPost('user_type'),
            ];

            if ($this->catModel->update($id, $data)) {
                session()->setFlashdata('success', 'Kočka byla úspěšně aktualizována!');
            } else {
                session()->setFlashdata('error', 'Chyba při aktualizaci koček!');
            }

            return redirect()->to('/manage');
        }

        $data = [
            'title' => 'Editace koček',
            'cat' => $cat
        ];
        return view('manage_edit', $data);
    }

    public function delete($id)
    {
        $cat = $this->catModel->find($id);
        if (!$cat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kočka nenalezena');
        }

        // Smazání fotky
        if ($cat['photo'] && file_exists('uploads/' . $cat['photo'])) {
            unlink('uploads/' . $cat['photo']);
        }

        if ($this->catModel->delete($id)) {
            session()->setFlashdata('success', 'Kočka byla úspěšně smazána!');
        } else {
            session()->setFlashdata('error', 'Chyba při mazání koček!');
        }

        return redirect()->to('/manage');
    }
}

