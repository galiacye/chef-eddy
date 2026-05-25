<?php

namespace App\Models;
use CodeIgniter\Model;

class UnitModel extends Model
{
    protected $table = 'units';
    protected $allowedFields = ['name'];
}