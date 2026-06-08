<?php

namespace App\Models;

use CodeIgniter\Model;

class Favorite extends Model
{
    protected $table            = 'favorites';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'cat_id'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
}
