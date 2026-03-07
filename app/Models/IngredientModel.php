<?php

namespace  App\Models;
use CodeIgniter\Model;

class IngredientModel extends Model
{
    protected $table = 'ingredients';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nom','image_url','category_id'];
    protected $returnType = 'object';

    public function getCategory()
    {
        return $this->db->table('ingredients_categorie')->get()->getResult();
    }

}
