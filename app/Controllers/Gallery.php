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
            ->select('cats.*, photos.image_path AS photo')
            ->join('photos', 'photos.cat_id = cats.id', 'left')
            ->where('cats.status', 'available')
            ->where('cats.deleted_at', null) 
            ->orderBy('cats.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Galerie koček - Portál adopce',
            'cats' => $cats
        ];

        return view('gallery', $data);
    }
}

