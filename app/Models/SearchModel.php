<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchModel extends Model
{
    protected $table = 'recettes';
    protected $primaryKey = 'id';

    public function searchRecipe(string $search)
    {
        return $this->select('recettes.id,
                            recettes.titre,
                            recettes.image_url,
                            recettes.difficulte,
                            recettes.temps_preparation,recettes.temps_cuisson,
                            recettes.nb_personnes')
            ->like('recettes.titre', $search)
            // ->where('recettes.statut','publié')
            ->get()
            ->getResultObject();
    }

    public function searchByIngredient(string $search)
    {       
        return $this->select('recettes.id,
                            recettes.titre,
                            recettes.image_url,
                            recettes.difficulte,
                            recettes.temps_preparation,recettes.temps_cuisson,
                            recettes.nb_personnes')
                    ->join('recette_ingredients','recettes.id = recette_ingredients.recette_id')
                    ->join('ingredients', 'recette_ingredients.ingredient_id = ingredients.id')
                    ->like('ingredients.nom',$search)
                    ->get()
                    ->getResultObject();
    }
}