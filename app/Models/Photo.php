<?php

namespace App\Models;

use CodeIgniter\Model;

class Photo extends Model
{
    protected $table            = 'photos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['cat_id', 'image_path', 'deleted_at'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
}
