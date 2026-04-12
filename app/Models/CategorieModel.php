<?php

namespace App\Models;

use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nom'];
    protected $returnType = 'object'; // 

    public function getAllCategories()
    {
        return $this->findAll();
    }

    public function getCategorie($id)
    {
        return $this->find($id);
    }
 //la catégorie d'une recette
    public function getRecipeCategorie(int $recipe_id)
    {
        return $this->select('categories.nom')
            ->join('recette_categories', 'recette_categories.categorie_id = categories.id')
            ->where('recette_categories.recette_id', $recipe_id)
            ->get()
            ->getResult();
    }
    // Toutes les recettes d'une catégorie
    public function getRecipesByCategorie(int $categorie_id)
    {
        return $this->db->table('recette_categories')
            ->select('recettes.id, recettes.titre, recettes.image_url')
            ->join('recettes', 'recettes.id = recette_categories.recette_id')
            ->where('recette_categories.categorie_id', $categorie_id)
            ->get()
            ->getResult();
    }
}
