<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use HTMLPurifier;
use HTMLPurifier_Config;



class Auth extends BaseController

{
    protected object $model;
    protected object $UserModel;
    protected object $RoleModel;

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


    public function register()
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        if ($this->request->is('post')===false) { //= recommandé car insensible à la casse 'POST':  if ($this->request->getMethod() !== post) 
//dd($this->request->getMethod());
            $data['roles'] = $this->RoleModel->findAll();
            return view('Auth/register', $data);
        } else {
//dd($this->request->getPost());
            $avatar_file = $this->request->getFile('avatar_url');
            $avatar_url = null;

            if ($avatar_file && $avatar_file->isValid() && !$avatar_file->hasMoved()) {

                $newName = $avatar_file->getRandomName();
                $avatar_file->move(FCPATH . 'uploads/avatars', $newName);

                $avatar_url = 'uploads/avatars/' . $newName;
            } else {
                $avatar_url = 'uploads/avatars/fantome.png';
            }

            $data = [
                'username'   => $this->request->getPost('username'),
                'email'      => $this->request->getPost('email'),
                'role_id'    => $this->request->getPost('role_id') ?? 1, // guest par défaut
                'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'nom'        => $this->request->getPost('nom'),
                'prenom'     => $this->request->getPost('prenom'),
                'avatar_url' => $avatar_url
            ];

            $this->UserModel->register($data);

            return redirect()->to('/')->with('success', 'Votre profil a bien été crée');
        }
    }


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
            return redirect()->to('login')->with('error', "Cet email n'existe pas");
        }

        if (!password_verify($password, $user->password)) {
            return redirect()->to('login')->with('error', 'Mot de passe incorrect');
        }

        $role_id = $user->role_id; //après avoir vérif user


        if ($user->role_id == 4) {
            return redirect()->to('login')->with('error', 'Compte banni');
        }
        //après cas d'échec, pas de session pour un banni ou inexistant
        session()->set([
            'user_id'  => $user->id,
            'username' => $user->username,
            'role_id'  => $user->role_id
        ]);

        if ($role_id == 3) {
            return redirect()->to('dashboard');
        }

        return redirect()->to('/'); // 1 et 2 par défaut
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
