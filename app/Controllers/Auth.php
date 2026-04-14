<?php

namespace App\Controllers;

use App\Models\RoleModel;
use HTMLPurifier;
use HTMLPurifier_Config;

class Auth extends BaseController
{
    protected $model;
    protected $UserModel;
    protected $RoleModel;

    public function __construct()
    {
        helper('form');
        $this->UserModel = Model('UserModel');
        $this->RoleModel = Model('RoleModel');
    }

    public function login()
    {
        return view('Auth/login');
    }

       // return redirect()->to('login')->with('success', 'Inscription réussie, vous pouvez maintenant vous connecter.');
    

    public function connect()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('login')->with('error', implode('<br>', $this->validator->getErrors()));
            //implode colle ensemble  en string les données du tableau errors avc br entre chaque
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->UserModel->getUserByEmail($email);

        if (!$user) {
            return redirect()->to('login')->with('error', 'Email introuvable');
        }

        if (!password_verify($password, $user->password)) {
            return redirect()->to('login')->with('error', 'Mot de passe incorrect');
        }

        if ($user->role_id == 4) {
            return redirect()->to('login')->with('error', 'Compte banni');
        }

        session()->set([
            'user_id'  => $user->id,
            'username' => $user->username,
            'role_id'  => $user->role_id
        ]);

        return redirect()->to('/');
    }
}
