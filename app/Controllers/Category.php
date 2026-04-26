<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\RecipeModel;
use App\Models\IngredientModel;
use App\Models\TagModel;

class Category extends BaseController
{
    protected $model;
    protected $returnType = 'object';
    public function __construct()
    {
        $this->model = model('CategoryModel');
    }

    //toutes les catégories : index
    public function index()
    {
        $categoryModel = model('CategoryModel');
        $categories = $categoryModel->findAll();
        $data = [
            'categories' => $categories
        ];

        return view('Category/index', $data);
    }
    //les recettes d'une catégorie: show
    public function showRecipesByCategory(int $category_id)
    {
        $categoryModel  = model('CategoryModel');
        $category = $categoryModel->getCategory($category_id);
        $recipes   = $categoryModel->getRecipesByCategory($category_id);

        $data = [
            'category'   => $category,//category et recipes sont ici des noms qu'on donne pour la vue
            'recipes'     => $recipes
        ];

        return view('Category/show', $data);
    }

    public function cAddCategory(): void
    {
        $data = [
            "nom_categorie" => "météo"
        ];
        $this->model->addCategory($data);
        echo 'insertion reussie';
    }




    public function addCategory()
    {
        helper('form');
        $categoryModel = model('CategoryModel');
    }
    public function updateCategory(int $category_id)
    {
        helper('form');
        $categoryModel = model('CategoryModel');
        $category = $categoryModel->find($category_id);
    }
    //renommage se fera dans branche dédiée
    public function deleteCategory(int $category_id)
    {
        $categoryModel = model('CategoryModel');
        $categoryModel->delete($category_id);
    }
    //option Alexis dans blog:
    public function cDeleteCategory(int $idCategory): void
    {
        $this->model->deleteCategory($idCategory);
        echo 'Suppression';
    }
}
