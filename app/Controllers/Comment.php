<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\RecipeModel;

class Comment extends BaseController
{

    private CommentModel $model;


    public function __construct()
    {
        $this->model = model('CommentModel');
        helper('form');
    }

    public function commentsIndex()
    {
        $status = $this->request->getGet('status');
        $comments = $this->model->commentsIndex($status); 
        $data = [
            'comments' => $comments,
            'status'   => $status
        ];
        return view('Admin/comments', $data);
    }




    public function updateCommentStatus(int $id, string $status)
    {
        $comment = $this->model->find($id); //find n'accepte qu'un param, $id
        if (!$comment) {
            return redirect()->back()->with('error', 'commentaire introuvable');
        }
        $allowed = ['pending', 'approved', 'rejected'];

        if (!in_array($status, $allowed)) {
            return redirect()->back()->with('error', 'Statut invalide');
        }

        $this->model->updateCommentStatus($id, $status);

        return redirect()->back()->with('success', 'Statut mis à jour');
    }

    public function deleteComment(int $id)
    {
        $this->model->deleteComment($id);
        return redirect()->back()->with('success', 'Commentaire supprimé');
        // redirect()->back() appelle previous_url en interne
    }

    /*
    public function showComment($id) bof il y a des details ds commentsIndex
    {
        $comment = $this->model->getCommentDetails($id);//aller faire la jointure...
    }
*/

    public function addComment(int $recipe_id)
    {
     if(!session()->get('user_id')) {
             return redirect()->to('register');
         }
        return view('comment/add-comment', ['recipe_id' => $recipe_id]);
    }

    public function saveComment()
    {

         if(!session()->get('user_id')){
            return redirect()->to('/register');
         }
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

        $recipe_id = $this->request->getPostGet('recipe_id'); //ici s'ecrit comme la var mais c'est le nom du champs html, ça ne vient pas de la bdd dc en anglais
        if ($this->validate($rules) === false) {
            return view('comment/add-comment', [
                'errors' => $this->validator->getErrors(),
                'recipe_id' => $this->request->getPostGet('recipe_id')
            ]); //with errors
        } else {

            $content = $this->request->getPostGet('content');
            //clean html
            $content = strip_tags($content, '<strong><em><u><ul><ol><li><a><br>');
            //allow safe tags only
            $content = preg_replace('/<a\s+href="([^"]*)"[^>]*>/i', '<a href="$1" rel="nofollow">', $content);
            $rating = $this->request->getPostGet('rating');

            $data = [
                'recipe_id' => $recipe_id,
                'content' => $content,
                "rating" => $rating,
                'user_id' => session()->get('user_id'),
                'status' => 'pending'
            ];

       

            $this->model->insert($data);
            //pour que user ne commente qu'une seule fois , utiliser addComment du model et :
            //
            //phpif (!$this->model->addComment($data)) {
            //session()->setFlashdata('error', 'Vous avez déjà commenté cette recette');
            //return redirect()->back();

            session()->setFlashdata('success', 'Votre commentaire est en attente de modération');
            return redirect()->back();
        }
    }


    public function updateComment(int $id)
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


        //get: on recup le comment en base
        if ($this->request->is('post') === false) {
            $comment = $this->model->find($id);
            //dd($this->model->findAll());
            $rating = $comment->rating;
            $data = [
                "comment" => $comment,
                "rating" => $rating,
            ];
            return view('comment/update-comment', $data);
        } else { //post: envoyer, validation

            if ($this->validate($rules) === false) {
                $comment = $this->model->find($id);
                return view('comment/update-comment', [
                    'comment' => $comment,
                    'rating' => $comment->rating,
                    'errors' => $this->validator->getErrors()
                ]);
            }

            $content = $this->request->getPostGet('content');
            $content = strip_tags($content, '<strong><em><u><ul><ol><li><a><br>');
            $rating = $this->request->getPostGet('rating');
            $data = [
                "content" => $content,
                "rating" => $rating,
                "status" => 'pending'
            ];
            $this->model->updateComment($id, $data); //on envoie en base
            return redirect()->back()->with('success', 'La modification de votre commentaire est en attente de modération');
        }
    }
    // public function replyComment()
    // {
    //     $data = [
    //         'recipe_id' => $this->request->getPost('recipe_id'),
    //         'parent_id'  => $this->request->getPost('parent_id'),
    //         'content'    => $this->request->getPost('content'),
    //         'user_id'    => session()->get('user_id'),
    //         'status'     => 'approved',
    //         'rating'     => null
    //     ];
    //     $this->model->insert($data);
    //     return redirect()->back()->with('success', 'Réponse publiée');
    // }


    //correction de la faille 

    public function replyComment()
{
    $recipeId = $this->request->getPost('recipe_id');
    $userId   = session()->get('user_id');
    $roleId   = session()->get('role_id');

    $recipe = model('RecipeModel')->find($recipeId);

    if (!$recipe) {
        return redirect()->back()->with('error', 'Recette introuvable.');
    }

    // L'utilisateur doit être soit le propriétaire de la recette, soit administrateur
    $estProprietaire = ($recipe['user_id'] == $userId);
    $estAdmin        = ($roleId == 3);

    if (!$estProprietaire && !$estAdmin) {
        return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à répondre à ce commentaire.');
    }

    $data = [
        'recipe_id' => $recipeId,
        'parent_id' => $this->request->getPost('parent_id'),
        'content'   => $this->request->getPost('content'),
        'user_id'   => $userId,
        'status'    => 'approved',
        'rating'    => null
    ];

    $this->model->insert($data);
    return redirect()->back()->with('success', 'Réponse publiée');
}

   
}
