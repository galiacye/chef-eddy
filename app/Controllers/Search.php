<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\RecipeModel;
use App\Models\TagModel;
use App\Models\CategorieModel;
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
        $search = $this->request->getGet('search');
        $data = [
            'recipes'=>$this->model->searchRecipe($search)
        ];
        return view('Search/results',$data);

    }
}