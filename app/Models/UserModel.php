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

    //register
    public function register(array $data) 
    {
        $user = $this->insert($data);
    }

    //login
    public function getUserByEmail(string $email)
    {
        return $this->where('email', $email)->first(); // = get()->getRow() pour un objet unique
    }

    public function getUsersWithRole()
    {
        return $this->select('users.*, roles.nom as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->findAll();
    }
}
