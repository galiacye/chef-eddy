<?php

namespace App\Controllers;

use CodeIgniter\Controllers;

class Ingredient extends BaseController
{
    private $model;

    public function __construct()
    {
        helper('form');

        $this->model = Model('ingredientModel');
    }


    public function ingredientsIndex(): string
    {
        $ingredients = $this->model->findAll();
        $data = [
            "ingredients" => $ingredients
        ];
        return view('Ingredients/ingredients-index', $data);
    }
    //ou plus court :
    // public function ingredientsIndex(): string
    // {
    //    return view('Ingredients/ingredients-index',['ingredients'=>$this->model->findAll()]);
    // }

    public function deleteIngredient($id)
    {
        $ingredient = $this->model->delete($id);
        return redirect()->to('/ingredients-index')->with('success', 'Ingredient supprimé');
    }

}
