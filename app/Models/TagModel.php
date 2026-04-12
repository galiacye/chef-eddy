<?php

namespace App\Models;

use CodeIgniter\Model;

class TagModel extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nom'];
    protected $returnType = 'object';


    public function getAllTags()
    {   //pour avoir ces tags en premier : Chef Eddy et Au chocolat
        return $this->findAll();
    }
// chercher les tags d'une recette
    public function getRecipeTags(int $id) 
    {
        return $this->select('tags.nom AS nom')
            ->join('recettes_tags', 'tags.id = recettes_tags.tag_id')
            ->where('recettes_tags.recette_id', $id)
            ->get()->getResult();
    }
//les recettes d'un tag
    public function getRecipesByTag(int $tag_id, int $limit = 6)
    {
        return $this->select('recettes.id, recettes.titre, recettes.image_url')
            ->join('recettes_tags', 'tags.id = recettes_tags.tag_id')
            ->join('recettes', 'recettes.id = recettes_tags.recette_id')
            ->where('recettes_tags.tag_id', $tag_id)
            ->orderBy('recettes.id', 'RANDOM') //pour afficher les recettes de façon aléatoire
            ->limit($limit)
            ->get()->getResult();
    }

    public function editTag() {}
}
