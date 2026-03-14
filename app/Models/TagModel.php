<?php
namespace App\Models;
use CodeIgniter\Model;

class TagModel extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nom'];

    public function getRecipeTags(int $id)//chercher les tags d'une recette
    {
        return $this->select('tags.nom AS nom_tag')
                    ->join('recettes_tags', 'tags.id = recettes_tags.tag_id')
                    ->where('recettes_tags.recette_id',$id)
                    ->get()->getResult();
    }
}