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
        $this->model = Model('SearchModel');
    }
    public function search()
    {
        $search  = $this->request->getGet('search') ?? ''; //coalescence nulle:

        $without = array_filter((array)($this->request->getGet('without') ?? []));
        $without = array_map('intval', $without);

        $recipes = $this->model->search($search, $without);

        return view('Search/results', ['recipes' => $recipes]);
    }
    ////si est null on prend la valeur par défaut: une chaine vide ;
    ////  cast en int
    // // $without = is_array($without)? $without:[$without]; donnerait un tableau 
    //mais pas nettoyé comme le fait array_filter()
    // public function search()
    // {
    //     $search     = $this->request->getGet('search');
    //     $ingredient = $this->request->getGet('ingredient');
    //     $without    = $this->request->getGet('without');

    //     $recipes = match (true) {
    //         !empty($ingredient) => $this->model->searchByIngredient($ingredient),
    //         !empty($search)     => $this->model->searchRecipe($search),
    //         !empty($without)    => $this->model->searchWithout($without),
    //         default             => []
    //     };

    //     $data = ['recipes' => $recipes];
    //     return view('Search/results', $data);
    // }

    //partie 2

    // public function search()
    // {
    //     $search      = $this->request->getGet('search');
    //l'opérateur de coalescence nulle ?? : isset($a) ? $a : $b
    //     $ingredients = array_filter((array)($this->request->getGet('ingredient') ?? []));//(array) force en tab car on va tomber sur des strings
    //si rien n'est coché renvoie un tab vide
    //     $without     = array_filter((array)($this->request->getGet('without') ?? []));
    //dans la check-box array_filter enlève les vides ""
    //     $recipes = match (true) {
    //      /   !empty($ingredients) => $this->model->searchWithIngredients($ingredients),
    //      /   !empty($search)      => $this->model->searchRecipe($search),
    //       /  !empty($without)     => $this->model->searchWithoutCategories($without),
    //         default              => []
    //     };

    //     return view('Search/results', ['recipes' => $recipes]);
    // }

}
