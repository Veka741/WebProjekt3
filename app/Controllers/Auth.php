<?php

namespace App\Controllers;

use App\Models\User;

/**
 * Auth – jednoduché přihlašování proti tabulce `users`.
 *
 * Projekt používá vlastní tabulku uživatelů (e-mail + bcrypt heslo + role),
 * kterou spravuje controller AdminUsers. Přihlášení ověřuje heslo funkcí
 * password_verify a ukládá údaje o uživateli do session. Stav přihlášení
 * (session 'logged_in') hlídá App\Filters\AuthFilter u chráněných rout.
 */
class Auth extends BaseController
{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
        helper(['form', 'url']);
    }

    /**
     * Zobrazí přihlašovací formulář (GET) nebo zpracuje přihlášení (POST).
     */
    public function login()
    {
        // Už přihlášený uživatel → rovnou do administrace
        if (session('logged_in')) {
            return redirect()->to('/');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'identity' => 'required|valid_email',
                'password' => 'required',
            ];

            if ($this->validate($rules)) {
                $user = $this->userModel->where('email', $this->request->getPost('identity'))->first();

                if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                    session()->set([
                        'user_id'   => $user['id'],
                        'identity'  => $user['email'],
                        'username'  => $user['username'],
                        'role'      => $user['role'],
                        'logged_in' => true,
                    ]);
                    session()->setFlashdata('success', 'Byli jste úspěšně přihlášeni.');
                    return redirect()->to('/');
                }

                session()->setFlashdata('error', 'Nesprávný e-mail nebo heslo.');
            } else {
                session()->setFlashdata('error', implode(' ', $this->validator->getErrors()));
            }

            return redirect()->back()->withInput();
        }

        return view('auth/login', [
            'title'    => 'Přihlášení – Portál adopce koček',
            'message'  => session('error') ?? session('success'),
            'identity' => ['name' => 'identity', 'id' => 'identity', 'type' => 'text',     'value' => set_value('identity')],
            'password' => ['name' => 'password', 'id' => 'password', 'type' => 'password'],
        ]);
    }

    /**
     * Odhlásí uživatele (zruší session) a přesměruje na přihlášení.
     */
    public function logout()
    {
        session()->remove(['user_id', 'identity', 'username', 'role', 'logged_in']);
        session()->setFlashdata('success', 'Byli jste úspěšně odhlášeni.');
        return redirect()->to('/auth/login');
    }

    /**
     * Stránka „zapomenuté heslo“ – v této aplikaci jen informační hláška.
     */
    public function forgot_password()
    {
        session()->setFlashdata('error', 'Pro obnovení hesla kontaktujte administrátora.');
        return redirect()->to('/auth/login');
    }
}
