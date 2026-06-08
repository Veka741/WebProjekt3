<?php

namespace App\Models;

use CodeIgniter\Model;

class Application extends Model
{
    protected $table            = 'applications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'cat_id', 'message', 'status'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;

    public function getApplicationsForUser($userId)
    {
        return $this->where('user_id', $userId)
            ->join('cats', 'cats.id = applications.cat_id', 'left')
            ->select('applications.*, cats.name as cat_name')
            ->findAll();
    }

    public function getApplicationsForCat($catId)
    {
        return $this->where('cat_id', $catId)
            ->join('users', 'users.id = applications.user_id', 'left')
            ->select('applications.*, users.first_name, users.last_name, users.email')
            ->findAll();
    }
}
