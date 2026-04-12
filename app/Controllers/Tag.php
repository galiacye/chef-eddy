<?php

namespace App\Controllers;

use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\IngredientModel;
use App\Models\CategorieModel;


class Tag extends BaseController
{
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
        $recipes = $tagModel->getRecipesByTag($tag_id);

        $data = [
            'tag' => $tag,
            'recipes' => $recipes
        ];

        return view('Tag/show', $data);
    }
}
