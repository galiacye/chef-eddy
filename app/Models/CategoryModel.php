<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name'];
    protected $returnType = 'object'; // 

    public function addCategory(array $data)
    {
        return $this->insert($data);

    }

    public function updateCategory(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    public function getAllCategories()
    {
        return $this->findAll();
    }

    public function deleteCategory(int $id)
    {
        return $this->delete($id);
    }

    public function getCategory($id)
    {
        return $this->find($id);
    }
 //la catégorie d'une recette
    public function getRecipeCategory(int $recipe_id)
    {
        return $this->select('categories.name')
            ->join('recipe_categories', 'recipe_categories.category_id = categories.id')
            ->where('recipe_categories.recipe_id', $recipe_id)
            ->get()
            ->getResult();
    }
    // Toutes les recettes d'une catégorie
    public function getRecipesByCategory(int $category_id)
    {//on utilise $db quand on est pas dans le model de la table appelée
        return $this->db->table('recipe_categories')
            ->select('recipes.id, recipes.title, recipes.image_url')
            ->join('recipes', 'recipes.id = recipe_categories.recipe_id')
            ->where('recipe_categories.category_id', $category_id)
            ->get()
            ->getResult();
    }


}
