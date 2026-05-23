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
    protected object $PasswordResetModel;

    public function __construct()
    {
        helper('form');
        $this->UserModel = Model('UserModel');
        $this->RoleModel = Model('RoleModel');
        $this->PasswordResetModel = model('PasswordResetModel');
    }

    public function login()
    {
        return view('Auth/login');
    }




    public function register()
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        if ($this->request->is('post') === false) { //= recommandé car insensible à la casse 'POST':  if ($this->request->getMethod() !== post) 

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
            //implode colle ensemble  en string les données du tableau errors avc <br> entre chaque
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






    public function forgotPassword()
    {
        //si c'est get on affiche le form comme à chaque fois
        if ($this->request->is('post') === false) {
            return view('Auth/forgot-password');
        }
        //on déclare

        $email = $this->request->getPost('email');
        $user  = $this->UserModel->getUserByEmail($email);
        //si pas d'user erreur
        if (!$user) {
            return redirect()->back()->with('error', "Cet email n'existe pas");
        }

        // Génération du token
        $token = bin2hex(random_bytes(32));

        // Supprime les anciens tokens de cet email
        $this->PasswordResetModel->where('email', $email)->delete(); //supp toutes les lignes de cet user

        // Stocke le nouveau token (expire dans 1 heure)
        $this->PasswordResetModel->insert([
            'email'      => $email,
            'token'      => $token,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 hour'))
        ]);

        // Envoi de l'email
        $emailService = \Config\Services::email();
        $emailService->setFrom('noreply@chef-eddy.fr', 'Chef Eddy');
        $emailService->setTo($email);
        $emailService->setSubject('Réinitialisation de votre mot de passe');
        $emailService->setMessage('
        <p>Bonjour ' . esc($user->username) . ',</p>
        <p>Cliquez sur ce lien pour réinitialiser votre mot de passe :</p>
        <a href="' . base_url('reset-password/' . $token) . '">Réinitialiser mon mot de passe</a>
        <p>Ce lien expire dans 1 heure.</p>
    ');

        if ($emailService->send()) {
            return redirect()->to('login')->with('success', 'Un email vous a été envoyé');
        } else {
            return redirect()->back()->with('error', "Erreur lors de l'envoi de l'email");
        }
    }




    public function resetPassword(string $token)
    {
        $reset = $this->PasswordResetModel
            ->where('token', $token)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->first();

        if (!$reset) {
            return redirect()->to('login')->with('error', 'Lien invalide ou expiré');
        }

        if ($this->request->is('post') === false) {
            return view('Auth/reset-password', ['token' => $token]);
        }

        $password = $this->request->getPost('password');

        $rules = [
            'password' => [
                'label'  => 'Mot de passe',
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required'   => 'Mot de passe requis',
                    'min_length' => 'Minimum 8 caractères'
                ]
            ],
            'confirm_password' => [
                'label'  => 'Confirmation',
                'rules'  => 'required|matches[password]',//matches native CI4 compare password et confirm_password
                'errors' => [
                    'required' => 'Confirmation requise',
                    'matches'  => 'Les mots de passe ne correspondent pas'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return view('Auth/reset-password', [
                'token'  => $token,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // Mise à jour du mot de passe
        $this->UserModel->where('email', $reset->email)
            ->set(['password' => password_hash($password, PASSWORD_DEFAULT)])
            ->update();

        // Suppression du token
        $this->PasswordResetModel->where('token', $token)->delete();

        return redirect()->to('login')->with('success', 'Mot de passe mis à jour, vous pouvez vous connecter');
    }
}
