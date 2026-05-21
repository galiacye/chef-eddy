<?php

namespace  App\Models;
use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nom'];
    protected $returnType = 'object';

    public function getRole($user_id)
    {
        return $this->select('role.nom');
    }
    
}