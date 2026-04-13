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

    public function save(array $data)
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'avatar_url' => 'uploaded[avatar_url]|max_size[avatar_url,2048]|is_image[avatar_url]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('register')->withInput()->with('errors', $this->validator->getErrors());
        }

        $avatarFile = $this->request->getFile('avatar_url');
        $avatarPath = null;
        if ($avatarFile->isValid() && !$avatarFile->hasMoved()) {
            $avatarPath = $avatarFile->store('avatars');
        }

        $userData = [
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'nom'      => $data['nom'] ?? null,
            'prenom'   => $data['prenom'] ?? null,
            'avatar_url' => $avatarPath,
            'role_id'  => 2
        ];

        $this->UserModel->save($userData);

        return redirect()->to('login')->with('success', 'Inscription réussie, vous pouvez maintenant vous connecter.');
    }

    public function authenticate()
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
            'user_nom' => $user->nom,
            'role_id'  => $user->role_id
        ]);

        return redirect()->to('/');
    }
}
