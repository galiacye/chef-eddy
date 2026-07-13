<?php

class SearchModel extends Model
{
    public function search(string $search = '', array $without = [])
    {
        $select = 'recipes.id, recipes.title, recipes.image_url,
            recipes.difficulty, recipes.prep_time,
            recipes.cook_time, recipes.portions';
        // On part de la table recipes
        $query = $this->db->table('recipes')
            ->select($select);
        // JOIN vers recipe_ingredients puis ingredients
        // -> une recette approuvée a toujours au moins un ingrédient (règle métier),
        //    donc un INNER JOIN suffit ici, pas besoin de LEFT JOIN
        $query->join('recipe_ingredients', 'recipes.id = recipe_ingredients.recipe_id');
        $query->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id');

        $query->where('recipes.status', 'approved')
            ->groupBy('recipes.id');
        // On cherche par titre ou par ingrédient en même temps
        if (!empty($search)) {
            // groupStart/groupEnd = parenthèses CI4 pour le SQL :
            // WHERE (recipes.title LIKE '%poulet%' OR ingredients.name LIKE '%poulet%')
            // AND recipes.id NOT IN (...)
            $query->groupStart()
                ->like('recipes.title', $search)
                ->orLike('ingredients.name', $search)
                ->groupEnd();
        }
        // Ensuite on filtre les ids à exclure
        if (!empty($without)) {
            $excludeIds = $this->db->table('recipe_ingredients')
                ->select('recipe_ingredients.recipe_id')
                ->join('ingredients', 'ingredients.id = recipe_ingredients.ingredient_id')
                ->whereIn('ingredients.category_id', $without)
                ->get()->getResultArray();
            $excludeIds = array_unique(array_column($excludeIds, 'recipe_id'));
            if (!empty($excludeIds)) {
                $query->whereNotIn('recipes.id', $excludeIds);
            }
        }
        return $query->get()->getResultObject();
    }
}