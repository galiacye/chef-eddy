<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class User extends BaseController
{
    
    private object $model;
    protected object $roleModel;
    protected object $commentModel;

    //il y a plusieurs façons d'instancier en CI4 : $this->model = new CommentModel();
    public function __construct()
    {
        helper('form');
        $this->model = Model('UserModel');
        $this->roleModel = Model('RoleModel');
        $this->commentModel = Model('CommentModel');
    }





    public function register() //ou dans Auth ???
    {
        if ($this->request->getMethod() !== 'post') {
            $data['roles'] = $this->roleModel->findAll();
            return view('User/register', $data);
        } else {

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
                'last_name'  => $this->request->getPost('last_name'),
                'first_name' => $this->request->getPost('first_name'),
                'avatar_url' => $avatar_url
            ];

            $this->model->register($data);

            return redirect()->to('/login');
        }
    }





    public function showUser(int $id)
    {
        $user = $this->model->find($id);
        $data = [
            'user' => $user
        ];
        return view('User/showUser', $data);
    }

    public function cIdUser(int $id)
    {
        $idUser = $this->model->find($id); //find = fonction native de ci4, c'est pourquoi ne figure pas ds le model
        return view('User/cIdUser', ['user' => $idUser]);
    }

    public function userIndex(): string
    {
        $users = $this->model->findAll(); //findAll = idem
        $data = [
            "users" => $users
        ];
        return view('User/userIndex', $data);
    }







    public function updateUser(int $id)
    {
        $user = $this->model->find($id);
        if (($this->request->is('post')) === false) {
            return view('User/updateUser', ['user' => $user]);
        } else {

            $rules = [
                "username" => [
                    "label" => "Pseudo",
                    "rules" => "min_length[2]|max_length[50]|required",
                    "errors" => [
                        "min_length" => "username trop court",
                        "max_length" => "username trop long",
                        "required" => "username requis"
                    ]
                ],
                "email" => [
                    "label" => "email",
                    "rules" => "min_length[2]|max_length[100]|valid_email|required",
                    "errors" => [
                        "valid_email" => "Email non valide",
                        "required" => "Email requis"
                    ]
                ],
                "password" => [
                    "label" => "Mot de passe",
                    "rules" => "permit_empty|min_length[2]|max_length[30]",
                    "errors" => [
                        "min_length" => "Mot de passe trop court",
                        "max_length" => "Mot de passe trop long",
                    ]
                ],
                "last_name" => [
                    "label" => "Nom",
                    "rules" => "permit_empty|min_length[2]|max_length[30]",
                    "errors" => [
                        "min_length" => "Nom trop court",
                        "max_length" => "Nom trop long",
                    ]
                ],
                "first_name" => [
                    "label" => "Prénom",
                    "rules" => "permit_empty|min_length[2]|max_length[30]",
                    "errors" => [
                        "min_length" => "Prenom trop court",
                        "max_length" => "Prenom trop long",
                    ]
                ],
                "avatar_url" => [
                    "label" => "Avatar",
                    "rules" => "permit_empty|is_image[avatar_url]|max_size[avatar_url,2048]|mime_in[avatar_url,image/jpg,image/jpeg,image/png]",
                    "errors" => [
                        "is_image" => "Le fichier doit être une image",
                        "max_size" => "L'image ne doit pas dépasser 2 Mo",
                        "mime_in" => "Le fichier doit être au format JPG ou PNG"
                    ]
                ],
                "role_id" =>  [
                    "label" => "Rôle",
                    "rules" => "permit_empty|is_natural|max_length[11]",
                    "errors" => [
                        "is_natural" => "Rôle invalide"
                    ]
                ]
            ];
            if (!$this->validate($rules)) {
                // echec de validation: on retourne le formulaire avec les erreurs
                return view('User/updateUser', [
                    'errors' => $this->validator->getErrors(),
                    'user' => $user
                ]);
            }

            // si validation récupération des données
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $last_name  = $this->request->getPost('last_name');
            $first_name = $this->request->getPost('first_name');
            $role_id = $this->request->getPost('role_id') ?: 1;
            // Gestion du fichier avatar

            $avatar_file = $this->request->getFile('avatar_url');
            $avatar_url = $user->avatar_url; // garde l'avatar actuel par défaut
            if ($avatar_file && $avatar_file->isValid() && !$avatar_file->hasMoved()) {
                //car ne peut être déplacé qu'une fois et l'a déjà été en tant que fichier temporaire au moment du chargement
                $newName = $avatar_file->getRandomName();
                $avatar_file->move(FCPATH . 'uploads/avatars', $newName);
                $avatar_url = 'uploads/avatars/' . $newName;
            }
            //$avatar_url = $avatar_file->store(); //native de ci4 stocke direct les uploads 
            //ds writable et nous on veut ds uploads
        }

        // Préparation des données pour le modèle
        $data = [
            "username" => $username,
            "email" => $email,
            "last_name"  => $last_name,
            "first_name" => $first_name,
            "avatar_url" => $avatar_url,
            "role_id" => $role_id
        ];
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Insertion dans la base
        $this->model->update($id, $data); //update fct native ci4

        // Retour view succès
        return redirect()->to('profile')->with('success', 'Vos modifications ont été enregistrées');
    }





    public function userChef(int $id)
    {
        $data = [
            'user' => $this->model->find($id)
        ];
        return view('User/userChef', $data);
    }





    //id peut être null
    public function profile(?int $id = null): string|RedirectResponse //convention pas vraiment de string ici 
    {

        // Si pas d'id passé, on prend l'utilisateur connecté en session
        $session = session();
        $user_id  = $id ?? $session->get('user_id');

        if (! $user_id) {
            return redirect()->to('/login')->with('errors', 'Vous devez être connecté.');
        }

        $user = $this->model->find($user_id);

        if (! $user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Utilisateur #$user_id introuvable.");
        }
        $recipeModel = model('RecipeModel');
        $userRecipes = $recipeModel->getRecipeByUser($user_id);
        $commentModel = model('CommentModel');
        $data = [
            'title'       => 'Profil — ' . esc($user->username),
            'user'        => $user,
            'isOwnProfile' => ($session->get('user_id') == (int) $user->id),
            'userRecipes' => $userRecipes,
            'comments' => $commentModel->commentsByUser($user_id)
        ];
        // dd($user_id);
        //dd($commentModel->commentsByUser($user_id));
        //dd($data['isOwnProfile']);
        return view('User/profile', $data);
    }
}
