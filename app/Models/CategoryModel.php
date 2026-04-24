<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nom'];
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
        return $this->select('categories.nom')
            ->join('recette_categories', 'recette_categories.categorie_id = categories.id')
            ->where('recette_categories.recette_id', $recipe_id)
            ->get()
            ->getResult();
    }
    // Toutes les recettes d'une catégorie
    public function getRecipesByCategory(int $category_id)
    {
        return $this->db->table('recette_categories')
            ->select('recettes.id, recettes.titre, recettes.image_url')
            ->join('recettes', 'recettes.id = recette_categories.recette_id')
            ->where('recette_categories.categorie_id', $category_id)
            ->get()
            ->getResult();
    }


}
