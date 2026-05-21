<?php

namespace App\Controllers;

use App\Models\CatModel;

class Gallery extends BaseController
{
    protected $catModel;

    public function __construct()
    {
        $this->catModel = new CatModel();
    }

    public function index()
    {
        $cats = $this->catModel->getAllCats();
        $data = [
            'title' => 'Galerie koček - Portál adopce',
            'cats' => $cats
        ];
        return view('gallery', $data);
    }
}

