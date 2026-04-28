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
    protected $returnType = 'object';

    public function updateCommentStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }

    public function commentsIndex()
    {
        return  $this->select('comments.id, users.username, users.id as user_id, recettes.titre as recipe_title, comments.content, comments.rating')
            ->join('users', 'comments.user_id = users.id')
            ->join('recettes', 'comments.recette_id = recettes.id')
            ->findAll();
    }

    public function deleteComment($id)
    {
        return $this->delete($id);
    }

    public function addComment($data)
    {
        return $this->insert($data);
    }
}
