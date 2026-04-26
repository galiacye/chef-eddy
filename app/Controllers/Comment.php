<?php
namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\RecipeModel;

class Comment extends BaseController
{
    private $model;
    protected $returnType = 'object';

    public function __construct(){
        $this->model = Model('CommentModel');
        helper('form');
    }

    public function allComments()
    {
        $comments = $this->model->findAll();
        $data = [
            "comments" => $comments,
            "title" => "Tous les commentaires"
        ];
        return view('comment/all-comments', $data);
    }

    public function showComment($id)
    {
        $comment = $this->model->getCommentDetails($id);//aller faire la jointure...
    }
}


