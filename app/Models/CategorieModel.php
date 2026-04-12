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

    public function getRecipeCategories(int $recipe_id)
    {
        return $this->select('categories.nom')
            ->join('recette_categories', 'recette_categories.categorie_id = categories.id')
            ->where('recette_categories.recette_id', $recipe_id)
            ->get()
            ->getResult();

    }
}