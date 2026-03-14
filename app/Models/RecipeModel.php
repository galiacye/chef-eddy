<?php

namespace  App\Models;
use CodeIgniter\Model;
use Config\Database;

class RecipeModel extends Model
{
    protected $table = 'recettes';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['user_id',
                                'titre',
                                'image_url',
                                'temps_preparation',
                                'temps_cuisson',
                                'contenu',
                                'nb_personnes',
                                'difficulte',
                                'statut',
                                'nb_vues'];
    protected $returnType = 'object';

    public function createRecipe(array $data)
    {
         return $this->insert($data);
    }
    
   public function getRecipe(int $id)
   {//syntaxe ci4 diff syntaxe sql
    return $this->select('recettes.titre, 
                         recettes.image_url, 
                         recettes.difficulte, 
                         recettes.temps_preparation,
                         recettes.temps_cuisson,
                         recettes.nb_personnes,
                         recettes.contenu, categories.nom AS nom_categorie')
                ->join('recette_categories', 'recettes.id = recette_categories.recette_id')
                ->join('categories','categories.id = recette_categories.categorie_id')
                ->where('recettes.id',$id)
                ->get()->getFirstRow();
   }
  
}

