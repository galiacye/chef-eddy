<?php
namespace App\Models;
use CodeIgniter\Model;

class FavoriteModel extends Model
{
    protected $table      = 'favorites';
    protected $allowedFields = ['user_id', 'recipe_id'];
    protected $useTimestamps = true;
    protected $updatedField  = ''; // pas de updated_at

    public function isFavorite(int $user_id, int $recipe_id): bool
    {
        return $this->where('user_id', $user_id)
                    ->where('recipe_id', $recipe_id)
                    ->countAllResults() > 0;
    }

    public function toggle(int $user_id, int $recipe_id): bool
    {
        if ($this->isFavorite($user_id, $recipe_id)) {
            $this->where('user_id', $user_id)
                 ->where('recipe_id', $recipe_id)
                 ->delete();
            return false; // retiré
        }

        $this->insert(['user_id' => $user_id, 'recipe_id' => $recipe_id]);
        return true; // ajouté
    }

    public function getByUser(int $user_id): array
    {
        return $this->select('recettes.*, favorites.created_at as favorited_at')
                    ->join('recettes', 'recettes.id = favorites.recipe_id')
                    ->where('favorites.user_id', $user_id)
                    ->orderBy('favorites.created_at', 'DESC')
                    ->findAll();
    }
}