<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'recipe_id',
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
    { //si un statut est fourni on retourne uniquement les comments qui ont ce statut
        if ($status) {
            return $this->select('comments.id, users.username, users.id as user_id, recipes.title as recipe_title, comments.content, comments.rating, comments.recipe_id, comments.status')
                ->join('users', 'comments.user_id = users.id')
                ->join('recipes', 'comments.recipe_id = recipes.id')
                ->where('comments.status', $status)
                ->findAll(); // : pour l'affichage par défaut
        } else {
            return $this->select('comments.id, users.username, users.id as user_id, recipes.title as recipe_title, comments.content, comments.rating, comments.recipe_id, comments.status')
                ->join('users', 'comments.user_id = users.id')
                ->join('recipes', 'comments.recipe_id = recipes.id')
                ->findAll();
        }
    }

    // public function commentsByRecipe(int $recipe_id)
    // {
    //     return $this->select('comments.id, recettes.titre as recipe_title, comments.content, comments.rating')
    //         ->join('recettes', 'comments.recette_id = recettes.id')
    //         ->where('comments.recette_id', $recipe_id)
    //         ->findAll();
    // }

    public function commentsByRecipe(int $recipe_id)
    {
        return $this->select('comments.id, comments.parent_id, comments.content, comments.rating, comments.status, users.username')
            ->join('recipes', 'comments.recipe_id = recipes.id')
            ->join('users', 'comments.user_id = users.id')
            ->where('comments.recipe_id', $recipe_id)
            ->where('comments.status', 'approved')
            ->orderBy('comments.id', 'ASC')
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
        $userCommentsIds = $this->select('id')
            ->where('user_id', $user_id)
            ->where('parent_id IS NULL')
            ->get()
            ->getResultArray();

        $ids = array_column($userCommentsIds, 'id');
        //dd($userCommentsIds);
        //dd($ids);
        if (empty($ids)) return [];
        //temps 2 ramener tout
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
