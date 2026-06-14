<?php

namespace App\Controllers;

use App\Models\Cat;

class Home extends BaseController
{
    /**
     * Úvodní stránka – uvítací hero, pár dostupných koček a krátký přehled.
     */
    public function index(): string
    {
        $catModel = new Cat();
        $available = $catModel->getCatsWithDetails('available');

        return view('home', [
            'title'    => 'Adopce koček – domů',
            'featured' => array_slice($available, 0, 3),
            'counts'   => $catModel->countByStatus(),
        ]);
    }
}
