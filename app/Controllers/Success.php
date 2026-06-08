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
            ->where('status', 'adopted')
            ->where('deleted_at', null)
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Úspěšné adopce - Portál adopce koček',
            'cats' => $cats
        ];
        return view('success', $data);
    }
}