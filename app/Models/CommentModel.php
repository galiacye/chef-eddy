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
//admin
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

//user
//seulement si je veux qu'ils ne commentent qu'une seule fois les recettes. 
//pour l'instant on pars sur la boucle sociale avc parent_id ds table comments

    // public function addComment(array $data)
    // {
    //     $everCommented = $this->where('user_id', $data['user_id'])
    //                             ->where('recette_id', $data['recette_id'])
    //                             ->first();

    //     if($everCommented){
    //         return false;
    //     }
    //     return $this->insert($data);
    // }
    

}
