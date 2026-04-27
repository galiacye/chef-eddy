<?php

namespace  App\Models;
use CodeIgniter\Model;

class IngredientModel extends Model
{
    protected $table = 'ingredients';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nom','category_id'];
    protected $returnType = 'object';

    public function getCategory()
    {
        return $this->db->table('ingredients_categories')->get()->getResult();
    }

    public function getRecipeIngredients($recipe_id)
    {
        return $this->select('ingredients.nom, ingredients.categorie, recette_ingredients.quantite, recette_ingredients.unite')
                    ->join('recette_ingredients','ingredients.id = recette_ingredients.ingredient_id')
                    ->where('recette_ingredients.recette_id',$recipe_id)
                    ->findAll();
    }

}
