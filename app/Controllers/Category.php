<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\RecipeModel;
use App\Models\IngredientModel;
use App\Models\TagModel;

class Category extends BaseController
{
    protected $model;
    protected $returnType = 'object';
    public function __construct()
    {
        $this->model = model('CategoryModel');
    }

    //toutes les catégories : index
    public function index()
    {
        $categoryModel = model('CategoryModel');
        $categories = $categoryModel->findAll();
        $data = [
            'categories' => $categories,
            'category' => $categories[0] ?? null //car ds la balise meta pas encore de var
        ];

        return view('Category/index', $data);
    }
    //les recettes d'une catégorie: show
    public function showRecipesByCategory(int $category_id)
    {
        $categoryModel  = model('CategoryModel');
        $category = $categoryModel->getCategory($category_id);
        $recipes   = $categoryModel->getRecipesByCategory($category_id);

        $data = [
            'category'   => $category, //category et recipes sont ici des noms qu'on donne pour la vue
            'recipes'     => $recipes
        ];

        return view('Category/show', $data);
    }

    //Admin

    public function adminCatIndex(){
        $categoryModel = model('CategoryModel');
        $categories = $categoryModel->findAll();

        $data = [
            'categories' => $categories
        ];
        return view('Admin/category-index', $data);

    }

    public function addCategory()
    {
        helper('form');
        $categoryModel = model('CategoryModel');

        if ($this->request->is('post') == false) {
            return view('Admin/category-add');
        } else {
            $data = [
                'name' => $this->request->getPost('name'),
                'image_url' => $this->request->getPost('image_url')
            ];
            $categoryModel->insert($data);
            return redirect()->to('/Admin/category-index');
        }
    }
    public function updateCategory(int $id)
    {
        helper('form');
        $categoryModel = model('CategoryModel');

        if ($this->request->is('post') == false) {
            $category = $categoryModel->find($id);
            return view('Admin/category-update', ['category' => $category]);
        } else {
            $data = [
                'name' => $this->request->getPost('name'),
                'image_url' => $this->request->getPost('image_url')
            ];
            $categoryModel->update($id, $data);
            return redirect()->to('/Admin/category-index');
        }
    }

    public function deleteCategory(int $id)
    {
        $categoryModel = model('CategoryModel');
        $categoryModel->delete($id);
        return redirect()->to('/Admin/category-index');
    }
    //option Alexis dans blog:
    public function cDeleteCategory(int $id): void
    {
        $this->model->deleteCategory($id);
        echo 'Suppression';
    }
}
