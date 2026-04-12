<?php

namespace App\Controllers;

use App\Models\CategorieModel;
use App\Models\RecipeModel;
use App\Models\IngredientModel;
use App\Models\TagModel;

class Categorie extends BaseController
{
    public function index()
    {
        $categorieModel = model('CategorieModel');
        $categories = $categorieModel->findAll();

        return view('Categorie/index', ['categories' => $categories]);
    }

    public function showRecipesByCategorie(int $categorie_id)
    {
        $categorieModel  = model('CategorieModel');
        $ingredientModel = model('IngredientModel');
        $tagModel        = model('TagModel');

        $data = [
            'categorie'   => $categorieModel->getCategorie($categorie_id),
            'ingredients' => $ingredientModel->getIngredientsByCategorie($categorie_id),
            'tags'        => $tagModel->getTagsByCategorie($categorie_id),
        ];

        return view('Categorie/show', $data);
    }
}
