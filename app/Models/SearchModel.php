<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchModel extends Model
{
    protected $table = 'recipes';
    protected $primaryKey = 'id';

    public function searchRecipe(string $search)
    {
        return $this->select('recipes.id,
                            recipes.title,
                            recipes.image_url,
                            recipes.difficulty,
                            recipes.prep_time, recipes.cook_time,
                            recipes.portions')
            ->like('recipes.title', $search)
            ->get()
            ->getResultObject();
    }

    public function searchByIngredient(string $search)
    {
        return $this->select('recipes.id,
                            recipes.title,
                            recipes.image_url,
                            recipes.difficulty,
                            recipes.prep_time, recipes.cook_time,
                            recipes.portions')
            ->join('recipe_ingredients', 'recipes.id = recipe_ingredients.recipe_id')
            ->join('ingredients', 'recipe_ingredients.ingredient_id = ingredients.id')
            ->like('ingredients.name', $search)
            ->get()
            ->getResultObject();
    }

    public function searchByTag(string $search)
    {
        return $this->select('recipes.id,
                            recipes.title,
                            recipes.image_url,
                            recipes.difficulty,
                            recipes.prep_time, recipes.cook_time,
                            recipes.portions')
            ->join('recipe_tags', 'recipes.id = recipe_tags.recipe_id')
            ->join('tags', 'recipe_tags.tag_id = tags.id')
            ->like('tags.name', $search)
            ->get()
            ->getResultObject();
    }

    public function searchByCategory(string $search)
    {
        return $this->select('recipes.id,
                            recipes.title,
                            recipes.image_url,
                            recipes.difficulty,
                            recipes.prep_time, recipes.cook_time,
                            recipes.portions')
            ->join('recipe_categories', 'recipes.id = recipe_categories.recipe_id')
            ->join('categories', 'recipe_categories.category_id = categories.id')
            ->like('categories.name', $search)
            ->get()
            ->getResultObject();
    }

    public function searchWithout(string $category)
    {
        $exclude = $this->db->table('recipe_ingredients')
            ->select('recipe_ingredients.recipe_id AS id')
            ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
            ->where('ingredients.category', $category)
            ->get()
            ->getResultObject();

        $excludeIds = array_column($exclude, 'id');

        $query = $this->db->table('recipes')
            ->select('recipes.id,
                    recipes.title,
                    recipes.image_url,
                    recipes.difficulty,
                    recipes.prep_time,
                    recipes.cook_time,
                    recipes.portions');

        if (!empty($excludeIds)) {
            $query->whereNotIn('recipes.id', $excludeIds);
        }

        return $query->get()->getResultObject();
    }
}
