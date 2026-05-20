<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Favorite extends BaseController
{

    public function toggle(int $recipe_id)
    {
        $user_id = session()->get('user_id');

        if (! $user_id) {
            return redirect()->to('/login')->with('errors', 'Vous devez être connecté.');
        }

        $favoriteModel = model('FavoriteModel');
        $favoriteModel->toggle($user_id, $recipe_id);

        return redirect()->back();
    }

    public function index(): string
{
    $user_id = session()->get('user_id');

    if (! $user_id) {
        return redirect()->to('/login')->with('errors', 'Vous devez être connecté.');
    }

    $favoriteModel = model('FavoriteModel');
    $data = [
        'title'     => 'Mes favoris',
        'favorites' => $favoriteModel->getByUser($user_id),
    ];
//dd($data['favorites']);
    return view('User/favorites', $data);
}
}
