<?php

namespace App\Models;

use CodeIgniter\Model;

class CatModel extends Model
{
    protected $table = 'cats';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'breed', 'age', 'description', 'photo', 'user_name', 'user_type', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllCats()
    {
        return $this->findAll();
    }

    public function getCatById($id)
    {
        return $this->find($id);
    }

    public function addCat($data)
    {
        return $this->insert($data);
    }

    public function updateCat($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteCat($id)
    {
        return $this->delete($id);
    }
}
