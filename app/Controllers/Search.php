<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\RecipeModel;
use App\Models\TagModel;
use App\Models\CategoryModel;
use App\Models\IngredientModel;
use HTMLPurifier;
use HTMLPurifier_Config;

class Search extends BaseController
{
    private $model;
    public function __construct()
    {
        helper('form');
        $this->model = Model('SearchModel');
    }

    public function search()
    {
        $search     = $this->request->getGet('search');
        $ingredient = $this->request->getGet('ingredient');

        $recipes = match (true) {
            !empty($ingredient) => $this->model->searchByIngredient($ingredient),
            !empty($search)     => $this->model->searchRecipe($search),
            default             => []
        };

        $data = ['recipes' => $recipes];
        return view('Search/results', $data);
    }
}