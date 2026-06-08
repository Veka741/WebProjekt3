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
        $cats = $this->catModel
            ->select('cats.*, photos.image_path AS photo')
            ->join('photos', 'photos.cat_id = cats.id', 'left')
            ->where('status', 'adopted')
            ->where('cats.deleted_at', null)
            ->orderBy('cats.updated_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Úspěšné adopce - Portál adopce koček',
            'cats' => $cats
        ];
        return view('success', $data);
    }
}