<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AuthFilter – protects routes that require a logged-in user.
 *
 * Apply to routes via app/Config/Filters.php  $filters array,
 * e.g.:
 *   'auth' => ['before' => ['manage', 'manage/*', 'admin/users', 'admin/users/*']]
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Přihlášení je uloženo v session (viz App\Controllers\Auth::login)
        if (! session()->get('logged_in')) {
            session()->setFlashdata('error', 'Pro přístup do administrace se musíte přihlásit.');
            return redirect()->to('/auth/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing needed on the way out
    }
}
