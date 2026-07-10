<?php

namespace  App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    const ADMIN  = 3;
    const AUTHOR = 2;
    const BANNED = 4;
    const GUEST  = 1;

    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name'];
    protected $returnType = 'object';

    public function getRole($user_id)
    {
        return $this->select('roles.name')
            ->join('users', 'users.role_id = roles.id')
            ->where('users.id', $user_id)
            ->first();
    }
}
