<?php
namespace App\Models;
use CodeIgniter\Model;

class IngredientsCategoriesModel extends Model{

    protected $table = 'ingredients_categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nom'];
    protected $returnType = 'object';



}