<?php

namespace App\Controllers;

use App\Models\Cat;

class Manage extends BaseController
{

    protected $catModel;

    public function __construct()
    {
        $this->catModel = new Cat();
    }

    public function index()
    {
        $cats = $this->catModel->findAll();
        $data = [
            'title' => 'Správa koček - Portál adopce',
            'cats' => $cats
        ];
        return view('manage', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $data = [
                'name' => $this->request->getPost('name'),
                'age' => $this->request->getPost('age'),
                'gender' => $this->request->getPost('gender'),
                'description' => $this->request->getPost('description'),
                'long_description' => $this->request->getPost('long_description'),
                'status' => $this->request->getPost('status'),
            ];

            if ($this->catModel->insert($data)) {
                session()->setFlashdata('success', 'Kočka byla úspěšně přidána!');
            } else {
                session()->setFlashdata('error', 'Chyba při přidávání kočky!');
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
            $data = [
                'name' => $this->request->getPost('name'),
                'age' => $this->request->getPost('age'),
                'gender' => $this->request->getPost('gender'),
                'description' => $this->request->getPost('description'),
                'long_description' => $this->request->getPost('long_description'),
                'status' => $this->request->getPost('status'),
            ];

            if ($this->catModel->update($id, $data)) {
                session()->setFlashdata('success', 'Kočka byla úspěšně aktualizována!');
            } else {
                session()->setFlashdata('error', 'Chyba při aktualizaci kočky!');
            }
            return redirect()->to('/manage');
        }

        $data = [
            'title' => 'Editace kočky',
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

        if ($this->catModel->delete($id)) {
            session()->setFlashdata('success', 'Kočka byla úspěšně smazána!');
        } else {
            session()->setFlashdata('error', 'Chyba při mazání kočky!');
        }
        return redirect()->to('/manage');
    }
}

