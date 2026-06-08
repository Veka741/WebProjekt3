<?php

namespace App\Controllers;

/**
 * Auth controller – extends Ion Auth's built-in Auth controller.
 *
 * Only login() and logout() are overridden here:
 *   – login() redirects to /admin/users on success instead of /
 *   – logout() redirects back to /auth/login
 *
 * All other Ion Auth routes (change_password, forgot_password, etc.)
 * are inherited from the parent class and still work.
 */
class Auth extends \IonAuth\Controllers\Auth
{
    /**
     * Point to app/Views/auth/ for the login template.
     * Parent default is 'IonAuth\Views\auth'.
     */
    protected $viewsFolder = 'auth';

    /**
     * Override login() to redirect to /admin/users after a successful sign-in.
     */
    public function login()
    {
        $this->data['title'] = 'Přihlášení – Portál adopce koček';

        // Required field validation
        $this->validation->setRule('identity', 'Email', 'required');
        $this->validation->setRule('password', 'Heslo',  'required');

        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
            $remember = (bool) $this->request->getVar('remember');

            if ($this->ionAuth->login(
                $this->request->getVar('identity'),
                $this->request->getVar('password'),
                $remember
            )) {
                // ✓ Successful login → go to admin user management
                $this->session->setFlashdata('message', $this->ionAuth->messages());
                return redirect()->to('/admin/users')->withCookies();
            }

            // ✗ Failed login
            $this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
            return redirect()->back()->withInput();
        }

        // Show the login form
        $this->data['message'] = $this->validation->getErrors()
            ? $this->validation->listErrors($this->validationListTemplate)
            : $this->session->getFlashdata('message');

        $this->data['identity'] = [
            'name'  => 'identity',
            'id'    => 'identity',
            'type'  => 'text',
            'value' => set_value('identity'),
        ];

        $this->data['password'] = [
            'name' => 'password',
            'id'   => 'password',
            'type' => 'password',
        ];

        return view('auth/login', $this->data);
    }

    /**
     * Override logout() – same as parent but with a Czech flash message.
     */
    public function logout()
    {
        $this->ionAuth->logout();
        $this->session->setFlashdata('message', 'Byli jste úspěšně odhlášeni.');
        return redirect()->to('/auth/login')->withCookies();
    }
}
