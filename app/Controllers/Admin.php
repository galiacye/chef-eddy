<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\RecipeModel;
use App\Models\TagModel;
use App\Models\CategorieModel;
use App\Models\IngredientModel;
use HTMLPurifier;
use HTMLPurifier_Config;

class Admin extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $recipeModel;
    protected $ingredientModel;
    protected $categorieModel;
    protected $tagModel;

    public function __construct()
    {
        helper('form');
        //nom de var plus explicite que juste model car sont plusieurs
        $this->userModel = Model('UserModel');
        $this->roleModel = Model('RoleModel');
        $this->recipeModel = Model('RecipeModel');
        $this->ingredientModel = Model('IngredientModel');
        $this->categorieModel = Model('CategorieModel');
        $this->tagModel = Model('TagModel');
    }

    public function dashboard()
    {

        return view('Admin/dashboard', [
            'nb_users' => $this->userModel->countAll(),
            'nb_recipes' => $this->recipeModel->countAll(), //devient countAllResults derrière un where:
            'nb_recipes_pending' => $this->recipeModel->where('statut', 'pending')->countAllResults()
        ]);
    }

    public function usersIndex()
    {
        $users = $this->userModel->findAll();
        return view('Admin/users-index', ["users" => $users]); //ici pas de $data car le param est passé directement à la vue,mais c'est pareil
    } //pareil que :
    //$users = $this->userModel->findAll();
    //$data = ["users" => $users];
    //return view('Admin/userIndex', $data);

    public function userDetails($id)
    {
        $user = $this->userModel->find($id);
        $recipes = $this->recipeModel->where('user_id', $id)->findAll();
        $data = [
            "user" => $user,
            "recipes" => $recipes
        ];
        return view('Admin/user-details', $data);
    }

    public function changeUserRole(int $id)
    {
        $this->userModel->update($id, [ //encore une native ci4
            'role_id' => $this->request->getPost('role_id')
        ]);
        return redirect()->to('Admin/user-details/' . $id);
    }

    public function addUser()
    {
        if (($this->request->is('post')) === false) {
            return view('Admin/add-user', ['roles' => $this->userModel->getUsersWithRole()]);
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
                    "rules" => "min_length[8]|max_length[255]|required",
                    "errors" => [
                        "min_length" => "Mot de passe trop court",
                        "max_length" => "Mot de passe trop long",
                        "required" => "Mot de passe obligatoire"
                    ]
                ],
                "nom" => [
                    "label" => "Nom",
                    "rules" => "permit_empty|min_length[2]|max_length[30]|required_if_role_author",
                    "errors" => [
                        "min_length" => "Nom trop court",
                        "max_length" => "Nom trop long",
                        "required" => "Nom obligatoire pour publier une recette"
                    ]
                ],
                "prenom" => [
                    "label" => "Prénom",
                    "rules" => "permit_empty|min_length[2]|max_length[30]|required_if_role_author",
                    //faire un fichier customRules ds app/validation+public rulesets ds config/validation
                    "errors" => [
                        "min_length" => "Prenom trop court",
                        "max_length" => "Prenom trop long",
                        "required" => "Prenom obligatoire pour publier une recette"
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
                ]

            ];
            if (!$this->validate($rules)) {
                // dd($this->validator->getErrors());
                // cas echec validation on retourne le formulaire avec les erreurs
                return view('Admin/add-user', [
                    'errors' => $this->validator->getErrors(),
                    'roles'  => $this->userModel->getRoles()
                ]);
            }

            // cas données valides : on les récupère
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = password_hash(random_bytes(8), PASSWORD_DEFAULT); //temporaire aléatoire
            $nom = $this->request->getPost('nom');
            $prenom = $this->request->getPost('prenom');
            $role_id = $this->request->getPost('role_id') ?: 1;

            // Gestion du fichier avatar : store inexistant dans ci4 ?
           // $avatar_file = $this->request->getFile('avatar_url');
            /*$avatar_url = null;
            if ($avatar_file && $avatar_file->isValid() && !$avatar_file->hasMoved()) {
                $avatar_url = $avatar_file->store();
            } else {
                $avatar_url = base_url('uploads/avatars/fantome.png');
            }/*/

            $avatar_file = $this->request->getFile('avatar_url');
            $avatar_url = null;

            if ($avatar_file && $avatar_file->isValid() && !$avatar_file->hasMoved()) {

                $newName = $avatar_file->getRandomName();
                $avatar_file->move(FCPATH . 'uploads/avatars', $newName);

                $avatar_url = 'uploads/avatars/' . $newName;
            } else {
                $avatar_url = 'uploads/avatars/fantome.png';
            }


            // Préparation des données pour le modèle
            $data = [
                "username" => $username,
                "email" => $email,
                "password" => $password,
                "nom" => $nom,
                "prenom" => $prenom,
                "avatar_url" => $avatar_url,
                "role_id" => $role_id
            ];

            // Insertion dans la base
            $this->userModel->insert($data); //insert = tjrs fct nat ci4

            return view('success');
        }
    }

    public function saveUser(int $id)
    {
        
    }


    public function deleteUser(int $id)
    {
        // $user = $this->userModel->find($id);  =>n'est utile que pour afficher nom de l'user supprimé, par ex
        $this->userModel->delete($id); //pattern natif de ci4 pas besoin de méthode customisée ds modèle
        return redirect()->to('Admin/users-index'); //créer vue admin avec index users
    }





    //public function recipesIndex()
    //{
    //  $users = $this->userModel->findAll();
    //$recipes = $this->recipeModel->findAll();
    //$data = [
    //  'recipes'=> $recipes,
    //'users'=>$users
    //];
    //return view('Admin/recipes-index', $data);
    //} implique une vue avec boucle imbriquée

    //avc ci4 les clés du tableau $data deviennent le nom des variables ds la vue:

    public function recipesIndex(): string
    {
        $recipes = $this->recipeModel->getRecipeAuthor();
        $data = ['recipes' => $recipes];
        return view('Admin/recipes-index', $data);
    }
    //équivaut à :
    //{
    //$data['recipes'] = $this->model->getRecipeAuthor();
    //return view('Admin/recipes-index', $data);
    //}


    public function recipeDetails($recipe_id)
    {
        $recipe = $this->recipeModel->find($recipe_id);
        $ingredients = $this->ingredientModel->getRecipeIngredients($recipe_id);
        $data = [
            'recipe' => $recipe,
            'ingredients' => $ingredients
        ];
        return view('Admin/recipe-details', $data);
    }

    public function deleteRecipe(int $id)
    {
        $this->recipeModel->delete($id);
        return redirect()->to('Admin/recipes-index')->with('success', 'Recette supprimée'); //idem pr recipe: ds vue admin
    }
}
