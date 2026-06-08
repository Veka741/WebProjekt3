<?php

namespace App\Controllers;

use App\Models\User;

class AdminUsers extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $activeUsers = $this->userModel->where('deleted_at', null)->findAll();
        $deletedUsers = $this->userModel->where('deleted_at !=', null)->findAll();
        
        $data = [
            'title' => 'Správa uživatelů - Portál adopce',
            'activeUsers' => $activeUsers,
            'deletedUsers' => $deletedUsers
        ];
        return view('admin_users', $data);
    }

    public function add()
    {
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'phone' => 'required|min_length[9]|max_length[20]',
                'type' => 'required|in_list[individual,organization]',
                'city' => 'required|min_length[2]|max_length[100]',
            ];

            if (!$this->validate($rules)) {
                return view('admin_users_add', ['errors' => $this->validator->getErrors()]);
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'type' => $this->request->getPost('type'),
                'city' => $this->request->getPost('city'),
                'notes' => $this->request->getPost('notes'),
            ];

            if ($this->userModel->insert($data)) {
                session()->setFlashdata('success', 'Uživatel byl úspěšně přidán!');
                return redirect()->to('/admin/users');
            } else {
                session()->setFlashdata('error', 'Chyba při přidávání uživatele!');
            }
        }
        return view('admin_users_add');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Uživatel nenalezen');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email',
                'phone' => 'required|min_length[9]|max_length[20]',
                'type' => 'required|in_list[individual,organization]',
                'city' => 'required|min_length[2]|max_length[100]',
            ];

            if (!$this->validate($rules)) {
                $data = [
                    'title' => 'Editace uživatele',
                    'user' => $user,
                    'errors' => $this->validator->getErrors()
                ];
                return view('admin_users_edit', $data);
            }

            $updateData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'type' => $this->request->getPost('type'),
                'city' => $this->request->getPost('city'),
                'notes' => $this->request->getPost('notes'),
            ];

            if ($this->userModel->update($id, $updateData)) {
                session()->setFlashdata('success', 'Uživatel byl úspěšně aktualizován!');
                return redirect()->to('/admin/users');
            } else {
                session()->setFlashdata('error', 'Chyba při aktualizaci uživatele!');
                $data = [
                    'title' => 'Editace uživatele',
                    'user' => $user,
                    'errors' => []
                ];
                return view('admin_users_edit', $data);
            }
        }

        $data = [
            'title' => 'Editace uživatele',
            'user' => $user,
            'errors' => []
        ];
        return view('admin_users_edit', $data);
    }

    public function softDelete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Uživatel nenalezen');
        }

        if ($this->userModel->update($id, ['deleted_at' => date('Y-m-d H:i:s')])) {
            session()->setFlashdata('success', 'Uživatel byl úspěšně archivován!');
        } else {
            session()->setFlashdata('error', 'Chyba při archivaci uživatele!');
        }
        return redirect()->to('/admin/users');
    }

    public function restore($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Uživatel nenalezen');
        }

        if ($this->userModel->update($id, ['deleted_at' => null])) {
            session()->setFlashdata('success', 'Uživatel byl úspěšně obnoven!');
        } else {
            session()->setFlashdata('error', 'Chyba při obnovení uživatele!');
        }
        return redirect()->to('/admin/users');
    }
}