<?php

namespace App\Controllers;

use App\Models\Cat;

class Success extends BaseController
{
    protected $Cat;

    public function __construct()
    {
        $this->Cat = new Cat();
    }

    public function index()
    {
        $adoptedCats = $this->Cat->where('status', 'adopted')->findAll();
        $data = [
            'title' => 'Úspěšné adopce - Portál adopce koček',
            'cats' => $adoptedCats
        ];
        return view('success', $data);
    }
}