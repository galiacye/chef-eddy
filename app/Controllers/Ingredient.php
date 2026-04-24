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

    public function showIngredient(int $id)
    {
        $ingredient = $this->model->find($id);
        $data = [
            "ingredient" => $ingredient
        ];
        return view('Ingredient/showIngredient', $data);
    }

    public function indexIngredients(): string
    {
        $ingredients = $this->model->findAll();
        $data = [
            "ingredients" => $ingredients
        ];
        return view('Ingredient/indexIngredients', $data);
    }

    public function createIngredient()
    {
        if (($this->request->is('post')) === false) {
            return view('Ingredient/createIngredient', ['categories' => $this->model->getCategory()]);
        } else {

            $rules = [
                "nom" => [
                    "label" => "Nom",
                    "rules" => "min_length[2]|max_length[50]|required",
                    "errors" => [
                        "min_length" => "Nom trop court",
                        "max_length" => "Nom trop long",
                        "required" => "Nom requis"
                    ]
                ],

                "image_url" => [
                    "label" => "image",
                    "rules" => "permit_empty|is_image[image_url]|max_size[image_url,2048]|mime_in[image_url,image/jpg,image/jpeg,image/png]",
                    "errors" => [
                        "is_image" => "Le fichier doit être une image",
                        "max_size" => "L'image ne doit pas dépasser 2 Mo",
                        "mime_in" => "Le fichier doit être au format JPG ou PNG"
                    ]
                ],
                "categorie_id" => [
                    "label" => "Catégorie",
                    "rules" => "required|integer",
                    "errors" => [
                        "required" => "La catégorie est requise",
                        "integer"  => "Catégorie invalide"
                    ]
                ],

            ];
            if (!$this->validate($rules)) {
                return view('Ingredient/createIngredient', [
                    'errors' => $this->validator->getErrors(),
                    'categories' => $this->model->getCategory()
                ]);
            }

            $image_file = $this->request->getFile('image_url');
            $image_url = null;
            if ($image_file && $image_file->isValid() && !$image_file->hasMoved()) {
                $image_url = $image_file->store();
            }

            $data = [
                'nom'       => $this->request->getPost('nom'),
                'image_url' => $image_url,
                'category_id' => $this->request->getPost('category_id')
            ];

            $this->model->insert($data);
            return view('success');
        }
    }

    public function deleteCategory()
    {

    }
}
