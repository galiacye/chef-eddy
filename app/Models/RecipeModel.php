<?php

namespace  App\Models;

use CodeIgniter\Model;
use Config\Database;
use App\models\IngredientModel;

class RecipeModel extends Model
{
    protected $table = 'recipes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'user_id',
        'title',
        'image_url',
        'prep_time',
        'cook_time',
        'content',
        'portions',
        'difficulty',
        'status',
        'views'
    ];
    protected $returnType = 'object';

    public function createRecipe(array $data)
    {
        return $this->insert($data);
    }

    public function getApprovedRecipes()
    {
        return $this->select('recipes.id, recipes.title, recipes.image_url')
            ->where('recipes.status', 'approved')
            ->findAll();
    }

    //syntaxe ci4 diff syntaxe sql
    public function getRecipe(int $id)
    {
        return $this->select('recipes.id,
                          recipes.title,
                          recipes.image_url,
                          recipes.difficulty,
                          recipes.prep_time,
                          recipes.cook_time,
                          recipes.portions,
                          recipes.content,
                          recipes.status,
                          users.username,
                          recipe_categories.category_id,
                          categories.name AS category_name')
            ->join('recipe_categories', 'recipes.id = recipe_categories.recipe_id', 'left') //left cas pas de categorie
            ->join('categories', 'categories.id = recipe_categories.category_id', 'left')
            ->join('users', 'users.id = recipes.user_id')
            ->where('recipes.id', $id)
            ->get()->getRow(); //ici on ne joint pas ing ni recettes_ing car les ingr sont déjà chargés 
        //par le contrôleur avec $ingredientModel->getRecipeIngredients($id)

        //dd($query->getCompiledSelect());pour voir le sql

    }

    public function getRecipeIngredients($recipe_id)
    {
        return $this->select('ingredients.name, recipe_ingredients.quantity, recipe_ingredients.unit')
            ->join('recipe_ingredients', 'recipes.id = recipe_ingredients.recipe_id')
            ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
            ->where('recipe_ingredients.recipe_id', $recipe_id)
            ->findAll();
    }

    public function getRecipesWithAuthor()
    {
        return $this->select('recipes.*, users.username')
            ->join('users', 'users.id = recipes.user_id')
            ->findAll();
    }

    public function getRecipesByStatus($status = null)
    {
        if ($status) {
            return $this->select('recipes.*, users.username')
                ->join('users', 'users.id = recipes.user_id')
                ->where('recipes.status', $status)
                ->orderBy('recipes.created_at', 'DESC')
                ->findAll();
        } else {
            return $this->select('recipes.*, users.username')
                ->join('users', 'users.id = recipes.user_id')
                ->orderBy('recipes.created_at', 'DESC')
                ->findAll();
        }
    }

    public function getRecipeByUser(int $id)
    {
        return $this->select('recipes.*, users.username')
            ->join('users', 'users.id = recipes.user_id')
            ->where('recipes.user_id', $id)
            ->findAll();
    }

    public function getChefEddyRecipes(int $limit = 6)
    {
        return $this->select('recipes.id, recipes.title, recipes.image_url')
            ->join('recipe_tags', 'recipes.id = recipe_tags.recipe_id')
            ->join('tags', 'tags.id = recipe_tags.tag_id')
            ->where('tags.name', 'chef-eddy')
            ->where('recipes.status', 'approved')
            ->orderBy('', 'RANDOM')
            ->limit($limit)
            ->get()
            ->getResult();
    }


    public function getRecipeTagIds($id)
    {
        return array_column(
            $this->db->table('recipe_tags')
                ->select('tag_id')
                ->where('recipe_id', $id)
                ->get()
                ->getResultArray(),
            'tag_id'
        );
    }
}
