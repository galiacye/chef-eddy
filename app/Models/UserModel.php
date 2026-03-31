<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    //query builder
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'nom',
        'prenom',
        'avatar_url',
        'role_id'
    ];
    protected $returnType = 'object';

    public function getUsersWithRole()
    {
        return $this->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->findAll();
    }

    
    
}
