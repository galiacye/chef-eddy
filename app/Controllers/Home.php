<?php

namespace App\Controllers;

use App\Libraries\Pdf;
use App\Models\IngredientModel;
use App\Models\IngredientsCategoriesModel;
use App\Models\RecipeModel;


class Home extends BaseController
{
    public function index(): string
    {
        helper('form');
        $recipeModel = model('RecipeModel');
        $Recipes = $recipeModel->findAll();

        $ingredientModel = model('IngredientModel');
        $ingredients = $ingredientModel->findAll();

        $ingredientsCategoriesModel = model('IngredientsCategoriesModel');

        $ingredientsCategories = $ingredientsCategoriesModel
            ->orderBy('nom', 'ASC')
            ->findAll();

        $tagModel = model('TagModel');
        $tags = $tagModel->findAll();

        $data = [
            'Recipes' => $Recipes,
            'ingredients' => $ingredients,
            'categories' => $ingredientsCategories,
            'tags' => $tags
        ];
        return view('Home/indexV2', $data);
    }

    public function salut()
    {
        return view('Home/test');
    }

    public function afficher()
    {
        return view('Home/afficher');
    }

    public function creerPdf()
    {
        $pdf = new Pdf;
        $pdf->generate('<h1>Test pdf</h1>');
    }
}
