<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;
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

        return view('Admin/dashboard',[
            'nb_users'=>$this->userModel->countAll(),
            'nb_recipes'=>$this->recipeModel->countAll(),
            'nb_recipes_pending'=>$this->recipeModel->countAll()
        ]);
    }

    public function usersIndex()
    {
        $users = $this->userModel->findAll();
        return view('Admin/users-index', ["users"=>$users]);//ici pas de $data car le param est passé directement à la vue,mais c'est pareil
    }//pareil que :
    //$users = $this->userModel->findAll();
    //$data = ["users" => $users];
    //return view('Admin/userIndex', $data);

    public function userDetails($id)
    {
        $user = $this->userModel->find($id);
        $data = [
            "user"=>$user
        ];
        return view('User/showUser', $id);
    }

     public function changeUserRole(int $id)
    {
        $user = $this->userModel->find($id);
        
    }

    public function deleteUser(int $id)
    {
        // $user = $this->userModel->find($id);  =>n'est utile que pour afficher nom de l'user supprimé, par ex
        $this->userModel->delete($id);//pattern natif de ci4 pas besoin de méthode customisée ds modèle
        return redirect()->to('Admin/users-index');//créer vue admin avec index users
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

     public function recipesIndex():string
    {
            $recipes = $this->recipeModel->getRecipeAuthor();
            $data = ['recipes' => $recipes];
            return view('Admin/recipes-index', $data);
    }
    //équivaut à :
      //{$data['recipes'] = $this->model->getRecipeAuthor();
        //return view('Admin/recipes-index', $data);}
    

    public function recipeDetails()
    {
        return view('Recipe/showRecipe');
    }

    public function deleteRecipe(int $id)
    {
        $this->recipeModel->delete($id);
        return redirect()->to('Admin/recipes-index')->with('success','Recette supprimée');//idem pr recipe: ds vue admin
    }



}