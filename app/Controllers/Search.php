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
    private object $model;
    public function __construct()
    {
        helper('form');
        $this->model = Model('SearchModel');
    }

    public function search()
    {
        $search     = $this->request->getGet('search');
        $ingredient = $this->request->getGet('ingredient');
        $without    = $this->request->getGet('without');

        $recipes = match (true) {
            !empty($ingredient) => $this->model->searchByIngredient($ingredient),
            !empty($search)     => $this->model->searchRecipe($search),
            !empty($without)    => $this->model->searchWithout($without),
            default             => []
        };

        $data = ['recipes' => $recipes];
        return view('Search/results', $data);
    }
}
