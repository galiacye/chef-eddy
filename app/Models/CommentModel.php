<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
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

    public function updateCommentStatus(int $id, string $status)
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

    public function deleteComment(int $id)
    {
        return $this->delete($id);
    }

    

   /*  public function edit_comment(int $id)
    {
    $comment = $this->commentModel->find($id);
        $data = [
            'status' => 'approved'
        ];
        $this->recipeModel->update($id, $data);
        return redirect()->to('Admin/recipes-index')->with('success', 'Recette validée');
    } */
}
