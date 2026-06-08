<?php

namespace App\Models;

use CodeIgniter\Model;

class Cat extends Model
{
    protected $table            = 'cats';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'age', 'gender', 'description', 'long_description',
        'status', 'deleted_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;

    public function getWithBreeds($id)
    {
        return $this->select('cats.*')
            ->join('cat_breeds', 'cat_breeds.cat_id = cats.id', 'left')
            ->join('breeds', 'breeds.id = cat_breeds.breed_id', 'left')
            ->find($id);
    }

    public function getWithPhotos($id)
    {
        $cat = $this->find($id);
        if ($cat) {
            $photoModel = new Photo();
            $cat['photos'] = $photoModel->where('cat_id', $id)
                ->where('deleted_at', null)
                ->findAll();
        }
        return $cat;
    }
}
