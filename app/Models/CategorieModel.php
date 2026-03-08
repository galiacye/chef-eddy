<?php
namespace App\Models;
use CodeIgniter\Model;

class CategorieModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nom'];
}