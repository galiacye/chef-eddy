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
        return view('Admin/dashboard');
    }

    public function deleteUser(int $id)
    {
        $this->userModel->delete($id);
        return redirect()->to('Admin/userIndex');//créer vue admin avec index users
    }


    public function deleteRecipe(int $id)
    {
        $this->recipeModel->delete($id);
        return redirect()->to('Admin/recipeIndex');//idem pr recipe
    }



}