<?php

namespace  App\Models;

use CodeIgniter\Model;
use Config\Database;
use App\models\IngredientModel;

class RecipeModel extends Model
{
  protected $table = 'recettes';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $allowedFields = [
    'user_id',
    'titre',
    'image_url',
    'temps_preparation',
    'temps_cuisson',
    'contenu',
    'nb_personnes',
    'difficulte',
    'statut',
    'nb_vues'
  ];
  protected $returnType = 'object';

  public function createRecipe(array $data)
    {
      return $this->insert($data);
    }

  public function getRecipe(int $id)
    { //syntaxe ci4 diff syntaxe sql
      return $this->select('recettes.id,
                          recettes.titre, 
                          recettes.image_url, 
                          recettes.difficulte, 
                          recettes.temps_preparation,
                          recettes.temps_cuisson,
                          recettes.nb_personnes,
                          recettes.contenu,
                          recettes.statut,
                          users.username,
                          recette_categories.categorie_id,
                          categories.nom AS nom_categorie')
      ->join('recette_categories', 'recettes.id = recette_categories.recette_id', 'left') //left pour cas où recette sans catégorie
      ->join('categories', 'categories.id = recette_categories.categorie_id', 'left')
      ->join('users', 'users.id = recettes.user_id')
      ->where('recettes.id', $id)
      ->get()->getRow(); //ici on ne joint pas ing ni recettes_ing car les ingr sont déjà chargés 
      //par le contrôleur avec $ingredientModel->getRecipeIngredients($id)

    //dd($query->getCompiledSelect());pour voir le sql

    }

  public function getIngredients($id)
    {
      return $this->db->table('recette_ingredients')
        ->select('ingredients.nom, ingredients.categorie, recette_ingredients.quantite, recette_ingredients.unite')
        ->join('ingredients', 'recette_ingredients.ingredient_id = ingredients.id')
        ->where('recette_id', $id)
        ->get()->getResult();
    }



  public function updateRecipe($id, $data)
    {
      return $this->update($id, $data);
    }

  public function getRecipesWithAuthor()
    {
      return $this->select('recettes.*, users.username')
        ->join('users', 'users.id = recettes.user_id')
        ->findAll(); //ici sql renvoie un résultat ds lequel username devient un attribut de $recipe
      //d'où le $recipe->username ds views/Admin/recipes-index
   }

  public function getRecipesByStatus($status = null)
    {
      if ($status) { // false si $status est null, true si $status vaut 'En attente', 'Approuvée', etc.
        return $this->select('recettes.*, users.username')
          ->join('users', 'users.id = recettes.user_id')
          ->where('recettes.statut', $status)
          ->findAll();
        }
        return $this->select('recettes.*, users.username')
          ->join('users', 'users.id = recettes.user_id')
          ->findAll();
      }

  public function getRecipeByUser($id)
    {
      return $this->select('recettes.*, users.username')
        ->join('users', 'users.id = recettes.user_id')
        ->where('recettes.user_id', $id)
        ->findAll();
    }

  //  recettes aléatoires avec tag chef-eddy
  public function getChefEddyRecipes(int $limit = 6)
  {
    return $this->select('recettes.id, recettes.titre, recettes.image_url')
      ->join('recette_tags', 'recettes.id = recette_tags.recette_id')
      ->join('tags', 'tags.id = recette_tags.tag_id')
      ->where('tags.nom_tag', 'chef-eddy')
      ->orderBy('', 'RANDOM')
      ->limit($limit)
      ->get()
      ->getResult();
  }
}
