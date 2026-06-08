<?php

namespace App\Controllers;

use App\Models\Cat;

class Gallery extends BaseController
{
    protected $catModel;

    public function __construct()
    {
        $this->catModel = new Cat();
    }

    public function index()
    {
        $cats = $this->catModel
            ->where('status', 'available')
            ->where('deleted_at', null)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Galerie koček - Portál adopce',
            'cats' => $cats
        ];
        return view('gallery', $data);
    }
}

