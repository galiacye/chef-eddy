<?php

namespace  App\Models;
use CodeIgniter\Model;

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
                                'nb_vues'
                                ];
    protected $returnType = 'object';

    // public function oneRecipe(int $id)
    // {
    //    return $this->select('id,user_id,title,image_url,temps_preparation,temps_cuisson,contenu,nb_personnes,difficulte,statut,nb_vues')
    //                 ->where('id',$id)->get()->getRow();
    // }

    // public function allRecipes()
    // {
    //     return $this->select('id,user_id,titre,image_url,temps_preparation,temps_cuisson,contenu,nb_personnes,difficulte,statut,nb_vues')
    //                 ->get()->getResult();
    // }

     public function createRecipe(array $data)
     {
         return $this->insert($data);
     }

    // public function updateRecipe(int $id, array $data)
    // {
    //     return $this->update($id, $data);
    // }

}