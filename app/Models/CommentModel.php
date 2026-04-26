<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $autoIncrement = true;
    protected $allowedFields = [
        'id',
        'recette_id',
        'user_id',
        'content',
        'rating',
        'status',
        'parent_id'
    ];

    public function updateCommentStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    
}
