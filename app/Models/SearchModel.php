<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchModel extends Model
{
    protected $table = 'recipes';
    protected $primaryKey = 'id';

    public function searchRecipe(string $search)
    {
        return $this->select('recipes.id,
                            recipes.title,
                            recipes.image_url,
                            recipes.difficulty,
                            recipes.prep_time, recipes.cook_time,
                            recipes.portions')
            ->like('recipes.title', $search)
            ->get()
            ->getResultObject();
    }

    public function searchByIngredient(string $search)
    {
        return $this->select('recipes.id,
                            recipes.title,
                            recipes.image_url,
                            recipes.difficulty,
                            recipes.prep_time, recipes.cook_time,
                            recipes.portions')
            ->join('recipe_ingredients', 'recipes.id = recipe_ingredients.recipe_id')
            ->join('ingredients', 'recipe_ingredients.ingredient_id = ingredients.id')
            ->like('ingredients.name', $search)
            ->get()
            ->getResultObject();
    }

    public function searchByTag(string $search)
    {
        return $this->select('recipes.id,
                            recipes.title,
                            recipes.image_url,
                            recipes.difficulty,
                            recipes.prep_time, recipes.cook_time,
                            recipes.portions')
            ->join('recipe_tags', 'recipes.id = recipe_tags.recipe_id')
            ->join('tags', 'recipe_tags.tag_id = tags.id')
            ->like('tags.name', $search)
            ->get()
            ->getResultObject();
    }

    public function searchByCategory(string $search)
    {
        return $this->select('recipes.id,
                            recipes.title,
                            recipes.image_url,
                            recipes.difficulty,
                            recipes.prep_time, recipes.cook_time,
                            recipes.portions')
            ->join('recipe_categories', 'recipes.id = recipe_categories.recipe_id')
            ->join('categories', 'recipe_categories.category_id = categories.id')
            ->like('categories.name', $search)
            ->get()
            ->getResultObject();
    }

    public function searchWithout(string $category)
    {
        $exclude = $this->db->table('recipe_ingredients')
            ->select('recipe_ingredients.recipe_id')
            ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
            ->where('ingredients.category', $category)
            ->get()
            ->getResultObject();

        $excludeIds = array_column($exclude, 'recipe_id');

        $query = $this->db->table('recipes')
            ->select('recipes.id,
                    recipes.title,
                    recipes.image_url,
                    recipes.difficulty,
                    recipes.prep_time,
                    recipes.cook_time,
                    recipes.portions');

        if (!empty($excludeIds)) {
            $query->whereNotIn('recipes.id', $excludeIds);
        }

        return $query->get()->getResultObject();
    }



    //partie 2

    // Façon php : ARRAY INTERSECT


    // public function searchWithIngredients(array $ingredientNames): array
    // {
    // Pour chaque ingrédient coché, on récupère les recipe_id qui le contiennent
    // et on fait l'intersection (AND)
    // $recipesIdsByIngredient = [];
    // foreach ($ingredientNames as $name) {
    //     $ids = $this->db->table('recipe_ingredients')
    //         ->select('recipe_ingredients.recipe_id')
    //         ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
    //         ->where('ingredients.name', $name)
    //         ->get()->getResultArray();
    //     $recipesIdsByIngredient[] = array_column($ids, 'recipe_id');
    // }

    // intersection de tous les sets
    //     $commonIds = array_shift($recipesIdsByIngredient);
    //     foreach ($recipesIdsByIngredient as $recipeIdByIngredient) {
    //         $commonIds = array_intersect($commonIds, $recipeIdByIngredient);
    //     }

    //     if (empty($commonIds)) return [];

    //     return $this->db->table('recipes')
    //         ->select('recipes.id, recipes.title, recipes.image_url, recipes.difficulty, recipes.prep_time, recipes.cook_time, recipes.portions')
    //         ->whereIn('recipes.id', array_values($commonIds))
    //         ->where('recipes.status', 'approved')
    //         ->get()->getResultObject();
    // }
    //  équivaut à 3 requêtes:
    //  étape 1
    //SELECT recipe_id FROM recipe_ingredients JOIN ingredients WHERE ingredients.name = 'tomate'
    // résultat : [1, 3, 5, 8]

    //SELECT recipe_id FROM recipe_ingredients JOIN ingredients WHERE ingredients.name = 'basilic'  
    //résultat : [1, 5, 9]

    //SELECT recipe_id FROM recipe_ingredients JOIN ingredients WHERE ingredients.name = 'ail'
    // résultat : [1, 3, 7]

    //étape 2: array_intersect fait la AND en php

    //étape 3 : requête finale avec ids qui reste: 
    //SELECT * FROM recipes WHERE id IN (1)





    // public function searchWithoutCategories(array $categories): array
    // {
    //     // recettes qui contiennent au moins une  des catégories à exclure
    //     $excludeIds = $this->db->table('recipe_ingredients')
    //         ->select('recipe_ingredients.recipe_id')
    //         ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
    //         ->whereIn('ingredients.category', $categories)
    //         ->get()->getResultArray();

    //     $excludeIds = array_column($excludeIds, 'recipe_id');

    //     $query = $this->db->table('recipes')
    //         ->select('recipes.id, recipes.title, recipes.image_url, recipes.difficulty, recipes.prep_time, recipes.cook_time, recipes.portions')
    //         ->where('recipes.status', 'approved');

    //     if (!empty($excludeIds)) {
    //         $query->whereNotIn('recipes.id', array_unique($excludeIds));
    //     }

    //     return $query->get()->getResultObject();
    // }

    // public function searchWithIngredients(array $ingredientNames): array
    // {
    //     return $this->db->table('recipes')
    //         ->select('recipes.id, recipes.title, recipes.image_url, recipes.difficulty, recipes.prep_time, recipes.cook_time, recipes.portions')
    //         ->join('recipe_ingredients', 'recipes.id = recipe_ingredients.recipe_id')
    //         ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
    //         ->whereIn('ingredients.name', $ingredientNames)
    //         ->groupBy('recipes.id')
    //         ->having('COUNT(DISTINCT ingredients.name)', count($ingredientNames))
    //         ->where('recipes.status', 'approved')
    //         ->get()->getResultObject();
    // }


    // soit il tape un nom de recette, ça roule on touche pas soit il tape un ingredient ça suffit 
    //on est pas dans le frigo pour l'instant, et ensuite sur les recettes tapées dans l'un de ces 
    //deux champs on veut filtrer 2 ou 3 allergènes

    public function search(string $search = '', array $without = [])
    {
        $select = 'recipes.id, recipes.title, recipes.image_url, 
               recipes.difficulty, recipes.prep_time, 
               recipes.cook_time, recipes.portions';

        // On cherche par titre ou par ingrédient en même temps
        $query = $this->db->table('recipes')
            ->select($select)
            ->join('recipe_ingredients', 'recipes.id = recipe_ingredients.recipe_id', 'left')
            ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id', 'left')
            ->where('recipes.status', 'approved')
            ->groupBy('recipes.id');

        if (!empty($search)) {
            $query->groupStart() //groupstart/end = parenthèse ci4 pour sql:
                //WHERE (recipes.title LIKE '%poulet%' OR ingredients.name LIKE '%poulet%')
                //AND recipes.id NOT IN (...)
                ->like('recipes.title', $search)
                ->orLike('ingredients.name', $search)
                ->groupEnd();
        }
        // Ensuite on filtre les ids à exclure
        if (!empty($without)) {
            $excludeIds = $this->db->table('recipe_ingredients')
                ->select('recipe_ingredients.recipe_id')
                ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
                ->whereIn('ingredients.category', $without)
                ->get()->getResultArray();

            $excludeIds = array_unique(array_column($excludeIds, 'recipe_id'));

            if (!empty($excludeIds)) {
                $query->whereNotIn('recipes.id', $excludeIds);
            }
        }
        return $query->get()->getResultObject();
    }
}
