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
        // Ion Auth's loggedIn() checks the session (and cookie remember-me)
        $ionAuth = new \IonAuth\Libraries\IonAuth();

        if (!$ionAuth->loggedIn()) {
            session()->setFlashdata('error', 'Pro přístup do administrace se musíte přihlásit.');
            return redirect()->to('/auth/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing needed on the way out
    }
}
