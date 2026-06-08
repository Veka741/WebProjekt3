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
            ->select('cats.*, ANY_VALUE(photos.image_path) AS photo, GROUP_CONCAT(breeds.name SEPARATOR ", ") AS breed')
            ->join('photos', 'photos.cat_id = cats.id', 'left')
            ->join('cat_breeds', 'cat_breeds.cat_id = cats.id', 'left')
            ->join('breeds', 'breeds.id = cat_breeds.breed_id', 'left')
            ->where('status', 'adopted')
            ->where('cats.deleted_at', null)
            ->groupBy('cats.id')
            ->orderBy('cats.updated_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Úspěšné adopce - Portál adopce koček',
            'cats' => $cats
        ];
        return view('success', $data);
    }
}