<?php

namespace App\Models;

use CodeIgniter\Model;

class TagModel extends Model
{
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['name', 'is_homepage'];
    protected $returnType = 'object';


    public function addTag(array $data) //ou edit ?
    {
        return $this->insert($data);
    }

    public function updateTag(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    public function deleteTag(int $id)
    {
        return $this->delete($id);
    }

    public function getAllTags()
    {
        return $this->findAll();
    }
    // chercher les tags d'une recette
    public function getRecipeTags(int $id)
    {
        return $this->select('tags.name AS name')
            ->join('recipe_tags', 'tags.id = recipe_tags.tag_id')
            ->where('recipe_tags.recipe_id', $id)
            ->get()->getResult();
    }
    //les recettes d'un tag
    public function getRecipesByTag(int $tag_id) //, int $limit = 6 en 2ème param pour limiter affichage
    {
        return $this->select('recipes.id, recipes.title, recipes.image_url')
            ->join('recipe_tags', 'tags.id = recipe_tags.tag_id')
            ->join('recipes', 'recipes.id = recipe_tags.recipe_id')
            ->where('recipe_tags.tag_id', $tag_id)
            ->where('recipes.status', 'approved')
            ->orderBy('recipes.id', 'RANDOM')
            //->limit($limit)
            ->get()->getResult();
    }

    public function getHomepageTag(): ?object
    {
        return $this->where('is_homepage', 1)->get()->getRow();
    }
    public function getTagByName(string $name): ?object
    {
        return $this->where('tags.name', $name)->get()->getRow();
    }
}
