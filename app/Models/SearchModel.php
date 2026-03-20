<?php
namespace App\Models;
use CodeIgniter\Model;

class SearchModel extends Model{
    protected $table = 'recettes';
    protected $primarykey = 'id';

    public function searchRecipe(string $search)
    {
        return $this->select('recettes.id,
                                recettes.titre,
                                recettes.image_url,
                                recettes.difficulte,
                                recettes.temps_preparation,recettes.temps_cuisson,')
                    ->like('recettes.titre',$search)
                    ->where('recettes.statut','publié')
                    ->get()
                    ->getResultObject();
    }
}