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
        $activeUsers = $this->userModel
            ->where('deleted_at', null)
            ->findAll();

        $deletedUsers = $this->userModel
            ->onlyDeleted()
            ->findAll();

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
                'first_name' => 'required|min_length[2]|max_length[100]',
                'last_name' => 'required|min_length[2]|max_length[100]',
                'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'role' => 'required|in_list[user,volunteer,admin]',
            ];

            if (!$this->validate($rules)) {
                return view('admin_users_add', [
                    'title' => 'Přidat uživatele',
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $data = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                'role' => $this->request->getPost('role'),
            ];

            if ($this->userModel->insert($data)) {
                session()->setFlashdata('success', 'Uživatel byl úspěšně přidán!');
                return redirect()->to('/admin/users');
            } else {
                session()->setFlashdata('error', 'Chyba při přidávání uživatele!');
            }
        }

        return view('admin_users_add', ['title' => 'Přidat uživatele', 'errors' => []]);
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Uživatel nenalezen');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'first_name' => 'required|min_length[2]|max_length[100]',
                'last_name' => 'required|min_length[2]|max_length[100]',
                'email' => 'required|valid_email',
                'role' => 'required|in_list[user,volunteer,admin]',
            ];

            if (!$this->validate($rules)) {
                return view('admin_users_edit', [
                    'title' => 'Editace uživatele',
                    'user' => $user,
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $updateData = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('role'),
            ];

            if ($this->userModel->update($id, $updateData)) {
                session()->setFlashdata('success', 'Uživatel byl aktualizován!');
                return redirect()->to('/admin/users');
            }
        }

        return view('admin_users_edit', [
            'title' => 'Editace uživatele',
            'user' => $user,
            'errors' => []
        ]);
    }

    public function softDelete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'Uživatel nenalezen');
            return redirect()->to('/admin/users');
        }

        if ($this->userModel->delete($id)) {
            session()->setFlashdata('success', 'Uživatel byl smazán!');
        } else {
            session()->setFlashdata('error', 'Chyba při mazání uživatele');
        }

        return redirect()->to('/admin/users');
    }

    public function restore($id)
    {
        $user = $this->userModel->onlyDeleted()->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'Uživatel nenalezen');
            return redirect()->to('/admin/users');
        }

        if ($this->userModel->update($id, ['deleted_at' => null])) {
            session()->setFlashdata('success', 'Uživatel byl obnoven!');
        } else {
            session()->setFlashdata('error', 'Chyba při obnovení');
        }

        return redirect()->to('/admin/users');
    }
}