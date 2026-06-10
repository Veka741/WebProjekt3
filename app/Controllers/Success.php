<?php

namespace App\Controllers;

use App\Models\Cat;

class Success extends BaseController
{
    protected $catModel;

    public function __construct()
    {
        $this->catModel = new Cat();
    }

    public function index()
    {
        $data = [
            'title' => 'Úspěšné adopce - Portál adopce koček',
            'cats'  => $this->catModel->getCatsWithDetails('adopted'),
        ];
        return view('success', $data);
    }
}