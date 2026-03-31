<?php
namespace App\Controllers;
use App\Models\RoleModel;
//ce controller n'a pas vraiment de raison d'être puisque c'est Admin qui se chargera des roles.
class Role extends BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = Model('RoleModel');
    }

    public function allRoles()
    {
        $roles = $this->model->findAll();
        return view('Role/all-roles',['roles'=>$roles]);
    }

}