<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
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

    public function commentsIndex(?string $status = null)
    {
        if ($status) { //si un statut est fourni on retourne uniquement les comments qui ont ce statut
            return $this->select('comments.id, users.username, users.id as user_id, recettes.titre as recipe_title, comments.content, comments.rating, comments.recette_id, comments.status')
                ->join('users', 'comments.user_id = users.id')
                ->join('recettes', 'comments.recette_id = recettes.id')
                ->where('comments.status', $status)
                ->findAll();
        } else { // : pour l'affichage par défaut
            return $this->select('comments.id, users.username, users.id as user_id, recettes.titre as recipe_title, comments.content, comments.rating, comments.recette_id, comments.status')
                ->join('users', 'comments.user_id = users.id')
                ->join('recettes', 'comments.recette_id = recettes.id')
                ->findAll();
        }
    }

    public function commentsByRecipe(int $recipe_id)
    {
        return $this->select('comments.id, recettes.titre as recipe_title, comments.content, comments.rating')
            ->join('recettes', 'comments.recette_id = recettes.id')
            ->where('comments.recette_id', $recipe_id)
            ->findAll();
    }

    // public function commentByUser(int $user_id)
    // {
    //     return $this->select('comments.id, users.username, comments.content, comments.rating, comments.parent_id, comments.status')
    //         ->join('users', 'comments.user_id = users.id')
    //         ->where('comments.user_id', $user_id)
    //         ->findAll();
    // }

    public function commentsByUser(int $user_id)
    {

        //définir les  commentaires originels de user:
        $userCommentsIds = $this->db->table('comments')
            ->select('id')
            ->where('user_id', $user_id)
            ->where('parent_id IS NULL')
            ->get()
            ->getResultArray();

        $ids = array_column($userCommentsIds, 'id');

        if (empty($ids)) return [];

        //user comments's and chef replies
        return $this->select('comments.id, users.username, comments.content, comments.rating,
                            comments.parent_id, comments.status, comments.user_id')
            ->join('users', 'comments.user_id = users.id')
            ->groupStart() //parenthèses en sql
            ->where('comments.user_id', $user_id)
            ->orWhereIn('comments.parent_id', $ids)
            ->groupEnd()
            ->findAll();
    }

    public function updateComment(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    public function deleteComment(int $id)
    {
        return $this->delete($id);
    }

    // user
    // seulement si on veut qu'ils ne commentent qu'une seule fois les recettes. 
    // pour l'instant on pars sur la boucle sociale avc parent_id ds table comments et une methode save qui utilise insert ds le ctrlr

    // public function addComment(array $data)
    // {
    //     $everCommented = $this->where('user_id', $data['user_id'])
    //         ->where('recette_id', $data['recette_id'])
    //         ->first();

    //     if ($everCommented) {
    //         return false;
    //     } else {
    //         return $this->insert($data);
    //     }
    // }


}
