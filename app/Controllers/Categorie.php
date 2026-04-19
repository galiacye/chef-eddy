<?php

namespace App\Controllers;

use App\Models\CategorieModel;
use App\Models\RecipeModel;
use App\Models\IngredientModel;
use App\Models\TagModel;

class Categorie extends BaseController
{
    protected $model;
    protected $returnType = 'object';
    public function __construct()
    {
        $this->model = model('CategorieModel');
    }

    //toutes les catégories : index
    public function index()
    {
        $categorieModel = model('CategorieModel');
        $categories = $categorieModel->findAll();
        $data = [
            'categories' => $categories
        ];

        return view('Categorie/index', $data);
    }
    //les recettes d'une catégorie: show
    public function showRecipesByCategorie(int $categorie_id)
    {
        $categorieModel  = model('CategorieModel');
        $categorie = $categorieModel->getCategorie($categorie_id);
        $recipes   = $categorieModel->getRecipesByCategorie($categorie_id);

        $data = [
            'categorie'   => $categorie,
            'recipes'     => $recipes
        ];

        return view('Categorie/show', $data);
    }

    public function cAddCategorie(): void
    {
        $data = [
            "nom_categorie" => "météo"
        ];
        $this->model->addCategorie($data);
        echo 'insertion reussie';
    }




    public function addCategory()
    {
        helper('form');
        $categorieModel = model('CategorieModel');
    }
    public function updateCategory(int $categorie_id)
    {
        helper('form');
        $categorieModel = model('CategorieModel');
        $categorie = $categorieModel->find($categorie_id);
    }
    //renommage se fera dans branche dédiée
    public function deleteCategory(int $categorie_id)
    {
        $categorieModel = model('CategorieModel');
        $categorieModel->delete($categorie_id);
    }
    //option Alexis dans blog:
    public function cDeleteCategorie(int $idCategorie): void
    {
        $this->model->deleteCategorie($idCategorie);
        echo 'Suppression';
    }
}
