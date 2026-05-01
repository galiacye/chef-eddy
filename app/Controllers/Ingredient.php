<?php

namespace App\Controllers;

use CodeIgniter\Controllers;

class Ingredient extends BaseController
{
    private object $model;

    public function __construct()
    {
        helper('form');

        $this->model = Model('IngredientModel');
    }


    public function ingIndex(): string
    {
        $ingredients = $this->model->ingIndex();

        $data = [
            "titre" => "Tous les ingrédients",
            "ingredients" => $ingredients
        ];
        return view('Admin/ing-index', $data);
    }
    //ou plus court :
    // public function ingredientsIndex(): string
    // {
    //    return view('Ingredients/ingredients-index',['ingredients'=>$this->model->findAll()]);
    // }
    //
    //inutile ingredients crées par recette

    // public function addIngredient($data)
    // {
    //     $ingredient = $this->model->insert($data);
    //     $data = [
    //         'ingredient'=> $ingredient
    //     ];
    //     return redirect()->to('Admin/ing-index')->with('success', 'Ingredient ajouté');
    // }

    public function deleteIngredient(int $id)
    {
        $ingredient = $this->model->delete($id);
        return redirect()->back()->with('success', 'Ingredient supprimé');
    }
}
