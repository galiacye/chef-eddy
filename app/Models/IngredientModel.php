<?php

namespace  App\Models;

use CodeIgniter\Model;

class IngredientModel extends Model
{
    protected $table = 'ingredients';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'category_id'];
    protected $returnType = 'object';

    public function getCategory()
    {
        return $this->db->table('ingredients_categories')
            ->orderBy('name', 'ASC')
            ->get()->getResult();
    }

    public function getRecipeIngredients(int $recipe_id)
    {
        return $this->select('ingredients.name, ingredients.category_id, recipe_ingredients.quantity, recipe_ingredients.unit')
            ->join('recipe_ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
            ->where('recipe_ingredients.recipe_id', $recipe_id)
            ->findAll();
    }

    public function ingIndex()
    {
        return $this->select('ingredients.name, ingredients.id')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    public function getCategoryIdByName(string $name): ?int
    {
        $cat = $this->db->table('ingredients_categories')
            ->where('name', $name)
            ->get()
            ->getRowArray();
        return $cat ? (int)$cat['id'] : null;
    }
}
