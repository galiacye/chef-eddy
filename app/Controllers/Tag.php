<?php
namespace App\Controllers;

use App\Models\TagModel;
use App\Models\RecipeModel;
use App\Models\IngredientModel;
use App\Models\CategorieModel;


class Tag extends BaseController
{
    
public function index()
{
    $tagModel = model('TagModel');
    $tags = $tagModel->findAll();

    return view('Tag/index', ['tags' => $tags]);
}





public function showRecipesByTag(int $tag_id)
    {
        $tagModel = model('TagModel');
        $recipes = $tagModel->getRecipesByTag($tag_id);

        return view('recipes_by_tag', ['recipes' => $recipes]);
    }
}