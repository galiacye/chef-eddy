<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    //query builder
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'last_name',
        'first_name',
        'avatar_url',
        'role_id'
    ];
    protected $returnType = 'object';

    //register
    public function register(array $data)
    {
        $user = $this->insert($data);
    }

    //connect
    public function getUserByEmail(string $email)
    {
        return $this->where('email', $email)->first(); // = get()->getRow() pour un objet unique
    }

    public function getUsersWithRole()
    {
        return $this->select('users.*, roles.name as role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->findAll();
    }

    public function getRole()
    {
        return $this->select('users.role_id, roles.name')
            ->join('roles', 'users.role_id = roles.id')
            ->find();
    }
}
