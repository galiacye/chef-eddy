<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\IngredientModel;
use App\Models\CategoryModel;


class Tag extends BaseController
{

    public function __construct()
    {
        helper('form');
    }
    //tous les tags
    public function index()
    {
        $tagModel = model('TagModel');
        $tags = $tagModel->getAllTags();

        $data = [
            'tags' => $tags
        ];

        return view('Tag/index', $data);
    }
    //les recettes d'un tag : show
    public function showRecipesByTag(int $tag_id)
    {
        $tagModel = model('TagModel');
        $tag = $tagModel->find($tag_id);

        if ($tag->name === 'World Food') {
            return redirect()->to(base_url('cuisine-du-monde'));
        }

        $recipes = $tagModel->getRecipesByTag($tag_id);
        $data = [
            'tag' => $tag,
            'recipes' => $recipes
        ];

        return view('tag/show', $data);
    }


    //admin
    public function adminTagIndex()
    {
        $tagModel = model('TagModel');
        $tags = $tagModel->findAll();

        $data = [
            'tags' => $tags
        ];
        return view('Admin/tag-index', $data);
    }

    public function addTag()
    {
        helper('form');
        $tagModel = model('TagModel');

        if ($this->request->is('post') == false) {
            return view('Admin/dashboard');
        } else {
            $data = [
                'name' => $this->request->getPost('name'),
                'is_homepage' => $this->request->getPost('is_homepage'),
                'image_url' => $this->request->getPost('image_url')
            ];
            $tagModel->insert($data);
            return redirect()->to('/Admin/dashboard');
        }
    }





    public function updateTag(int $id)
    {
        helper('form');
        $tagModel = model('TagModel');
        $tag = $tagModel->find($id);

        if ($this->request->is('post') == false) {
            $tag = $tagModel->find($id);
            return view('Admin/tag-update', ['tag' => $tag]);
        } else {
            $data = [
                'name' => $this->request->getPost('name'),
                'image_url' => $this->request->getPost('image_url')
            ];
            $tagModel->update($id, $data);
            return redirect()->to('/Admin/tag-index');
        }
    }

    public function deleteTag(int $id)
    {
        $tagModel = model('TagModel');
        $tagModel->delete($id);

        return redirect()->to('Admin/tag-index')->with('success', 'Tag supprimé avec succès.');
    }
}
