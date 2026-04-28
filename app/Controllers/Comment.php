<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\RecipeModel;

class Comment extends BaseController
{
    private $model;

    //il y a plusieurs façons d'instancier en CI4 : $this->model = new CommentModel();s
    public function __construct()
    {
        $this->model = new CommentModel();
        helper('form');
    }

    public function commentsIndex()
    {
        $comments = $this->model->commentsIndex();
        $data = [
            "comments" => $comments,
            "title" => "Tous les commentaires"
        ];
        return view('Admin/comments', $data);
    }

    public function updateCommentStatus($id, $status)
    {
        $comment = $this->model->find($id, $status);
        if (!$comment) {
            return redirect()->back()->with('error', 'commentaire introuvable');
        }
        $allowed = ['Approuve', 'Rejeté', 'En attente'];

        if (!in_array($status, $allowed)) {
            return redirect()->back()->with('error', 'Statut invalide');
        }

        $this->model->updateCommentStatus($id, $status);

        return redirect()->back()->with('success', 'Statut mis à jour');
    }

    public function deleteComment($id)
    {
        $this->model->deleteComment($id);
        return redirect()->to(previous_url());
        //ou redirect()->back() qui appelle previous_url en interne!
    }

    /*
    public function showComment($id) bof il y a des details ds commentsIndex
    {
        $comment = $this->model->getCommentDetails($id);//aller faire la jointure...
    }
*/

    public function addComment()
    {
        return view('comment/add-comment');
    }

    public function saveComment()
    {
        $rules = [
            "content" => [
                "label" => "content",
                "rules" => "min_length[3]|max_length[1500]|required",
                "errors" => [
                    "min_length" => "Commentaire trop court",
                    "max_length" => "Commentaire trop long"

                ]
            ],
            "rating" => [
                "label" => "rating",
                "rules" => "required|integer|greater_than_equal_to[1]|less_than_equal_to[5]",
                "errors" => [
                    "required" => "La note est requise",
                    "integer" => "La note doit être un entier",
                    "greater_than_equal_to" => "La note doit être au moins 1",
                    "less_than_equal_to" => "La note doit être au plus 5"
                ]
            ]

        ];
        if ($this->validate($rules) === false) {
            return view('comment/add-comment', [
                'errors' => $this->validator->getErrors()
            ]); //with errors
        } else {
            $content = $this->request->getPostGet('content');
            //clean html
            $content = strip_tags($content, '<p><strong><em><u><ul><ol><li><a><br>');
            //allow safe tags only
            $content = preg_replace('/<a\s+href="([^"]*)"[^>]*>/i', '<a href="$1" rel="nofollow">', $content);
            $rating = $this->request->getPostGet('rating');

            $data = [
                "content" => $content,
                "rating" => $rating,
                'user_id' => 1, //session('user_id'),
                'status' => 'pending'
            ];

            //dd(session()->get());

            $this->model->addComment($data);
            session()->setFlashdata('success', 'Votre commentaire est en attente de modération');
            return redirect()->back();
        }
    }


    public function updateComment($id)
    {
        $rules = [
            "content" => [
                "label" => "content",
                "rules" => "min_length[3]|max_length[1500]|required",
                "errors" => [
                    "min_length" => "Commentaire trop court",
                    "max_length" => "Commentaire trop long"

                ]
            ],
            "rating" => [
                "label" => "rating",
                "rules" => "required|integer|greater_than_equal_to[1]|less_than_equal_to[5]",
                "errors" => [
                    "required" => "La note est requise",
                    "integer" => "La note doit être un entier",
                    "greater_than_equal_to" => "La note doit être au moins 1",
                    "less_than_equal_to" => "La note doit être au plus 5"
                ]
            ]
        ];



        if ($this->request->is('post') === false) {
            $comment = $this->model->oneComment($id);
            $rating = $comment->rating;
            $data = [
                "comment" => $comment,
                "rating" => $rating
            ];
            return view('Comment/updateComment', $data);
        } else {

            if ($this->validate($rules) === false) {
                $comment = $this->model->oneComment($id);
                return view('Comment/updateComment', [
                    'comment' => $comment,
                    'rating' => $comment->rating,
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $content = $this->request->getPostGet('content');
            $rating = $this->request->getPostGet('rating');
            $data = [
                "content" => $content,
                "rating" => $rating
            ];
            $this->model->updateComment($id, $data);
            return redirect()->back();
        }
    }
}
