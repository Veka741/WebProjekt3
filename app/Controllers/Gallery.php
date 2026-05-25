<?php

namespace App\Controllers;

use App\Models\Cat;

class Gallery extends BaseController
{
    protected $Cat;

    public function __construct()
    {
        $this->Cat = new Cat();
    }

    public function index()
    {
        $cats = $this->Cat->findAll();
        $data = [
            'title' => 'Galerie koček - Portál adopce',
            'cats' => $cats
        ];
        return view('gallery', $data);
    }
}

