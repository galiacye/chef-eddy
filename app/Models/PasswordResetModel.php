<?php 
namespace  App\Models;

use CodeIgniter\Model;
use Config\Database;


class PasswordResetModel extends Model
{
    protected $table      = 'password_resets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'token', 'expires_at'];
    protected $returnType = 'object';
}