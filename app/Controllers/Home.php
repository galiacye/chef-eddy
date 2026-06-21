<?php

namespace App\Controllers;

use App\Libraries\Pdf;
use App\Models\IngredientModel;
use App\Models\IngredientsCategoriesModel;
use App\Models\RecipeModel;
use App\Models\TagModel;


class Home extends BaseController
{
    public function index(): string
    {
        helper('form');
        $recipeModel = model('RecipeModel');

        $tagModel = model('TagModel');
        $tags = $tagModel->findAll();
        $homepageTag = $tagModel->getHomepageTag();

        $recipes = $homepageTag ? $tagModel->getRecipesByTag($homepageTag->id) : $recipeModel->getApprovedRecipes();
        $ingredientModel = model('IngredientModel');
        $ingredients = $ingredientModel->findAll();

        $ingredientsCategoriesModel = model('IngredientsCategoriesModel');
        $ingredientsCategories = $ingredientsCategoriesModel
            ->orderBy('name', 'ASC')
            ->where('id !=', 13) //"autres": utile pour la saisie, pas un filtre pertinent
            ->findAll();


        $data = [
            'recipes' => $recipes,
            'ingredients' => $ingredients,
            'categories' => $ingredientsCategories,
            'tags' => $tags,
            'homepageTag' => $homepageTag, //éventuellement pour afficher titre du tag

        ];
        return view('Home/index', $data);
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
