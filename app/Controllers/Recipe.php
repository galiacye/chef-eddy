<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Models\TagModel;
use App\Models\CategoryModel;
use App\Models\IngredientModel;
use App\Models\UnitModel;
use HTMLPurifier;
use HTMLPurifier_Config;

class Recipe extends BaseController
{
    private object $model;
    protected object $returnType;

    //il y a plusieurs façons d'instancier en CI4 : $this->model = new CommentModel();

    public function __construct()
    {
        helper('form');

        $this->model = Model('RecipeModel');
    }


    public function showRecipe(int $id)
    {

        $recipeModel     = model('RecipeModel');
        $tagModel = model('TagModel');
        $ingredientModel = model('IngredientModel');
        $categoryModel  = model('CategoryModel');
        $unitModel = model('UnitModel');
        $commentModel = model('CommentModel');
        $favoriteModel = model('FavoriteModel');


        $recipe = $recipeModel->getRecipe($id); // d'abord on récupère

        if (!$recipe || $recipe->status !== 'approved') { //ensuite on vérifie
            return redirect()->to('/recipe-index')->with('error', 'Recette non disponible.');
        }


        $user_id = session()->get('user_id');
        $isFav = false;
        if ($user_id) {
            $isFav = $favoriteModel->isFavorite($user_id, $id);
        }

        //dd($recipe, $id);

        $data = [
            'recipe'      => $recipe, //déjà récup'
            'tags'        => $tagModel->getRecipeTags($id),
            'ingredients' => $ingredientModel->getRecipeIngredients($id),
            'categories'  => $categoryModel->getRecipeCategory($id), // une recette peut avoir plusieurs catégories
            'units'      => array_column($unitModel->findAll(), 'name'), // ['kg','g','ml'...],
            'comments'    => $commentModel->commentsByRecipe($id),
            'user_id' => session()->get('user_id'),
            'isFav' => $isFav
        ];
        // dd($data['ingredients']);
        return view('Recipe/show-recipe', $data);
    }



    public function recipeIndex(): string
    { //avc ci4 les clés du tableau $data deviennent le nom des variables ds la vue:
        //$recipes = $this->model->getRecipeAuthor();
        //$data = ['recipes' => $recipes]; équivaut à :
        $data['recipes'] = $this->model->getApprovedRecipes();
        return view('Recipe/recipe-index', $data);
    }





    // createRecipe:
    // validation ,upload image, purification Quill, tables de liaison, gestion ingrédients intelligente 
    public function createRecipe()
    {

        $recipeModel = model('RecipeModel');
        $tagModel = model('TagModel');
        $ingredientModel = model('IngredientModel');
        $categoryModel = model('CategoryModel');
        $unitModel = model('UnitModel');
        $commentModel = model('CommentModel');
        $favoriteModel = model('FavoriteModel');


        if ($this->request->is('post') === false) { // =if ($this->request->getMethod() !== 'post')

            return view('Recipe/create-recipe', [
                'tags'       => $tagModel->findAll(),
                'categories' => $categoryModel->findAll(),
                'units' => array_column($unitModel->findAll(), 'name'), // ['kg','g','ml'...]
                'categories_ing_db'  => $ingredientModel->getCategory()
            ]);
        } else {
            // L'user_id vient de la session
            $role_id = session()->get('role_id');
            if ($role_id == 2 || $role_id == 3) {
                //règles de validation à factoriser 
                $rules = [
                    "title" => [
                        "label" => "Titre",
                        "rules" => "required|min_length[2]|max_length[50]",
                        "errors" => [
                            "required"   => "Titre requis",
                            "min_length" => "Titre trop court",
                            "max_length" => "Titre trop long",
                        ]
                    ],
                    "image_url" => [
                        "label" => "Image",
                        "rules" => "permit_empty|is_image[image_url]|max_size[image_url,2048]|mime_in[image_url,image/jpg,image/jpeg,image/png]",
                        "errors" => [
                            "is_image" => "Le fichier doit être une image",
                            "max_size" => "L'image ne doit pas dépasser 2 Mo",
                            "mime_in"  => "Le fichier doit être au format JPG ou PNG"
                        ]
                    ],
                    "prep_time" => [
                        "label" => "Temps de préparation",
                        "rules" => "permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[2880]",
                        "errors" => [
                            "integer"               => "Le temps de préparation doit être un nombre entier",
                            "greater_than_equal_to" => "Le temps de préparation doit être d'au moins 1 minute",
                            "less_than_equal_to"    => "Le temps de préparation ne peut pas dépasser 2880 minutes (48h)"
                        ]
                    ],
                    "cook_time" => [
                        "label" => "Temps de cuisson",
                        "rules" => "permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[2880]",
                        "errors" => [
                            "integer"               => "Le temps de cuisson doit être un nombre entier",
                            "greater_than_equal_to" => "Le temps de cuisson doit être d'au moins 1 minute",
                            "less_than_equal_to"    => "Le temps de cuisson ne peut pas dépasser 2880 minutes (48h)"
                        ]
                    ],
                    "content" => [
                        "label" => "Étapes de la recette",
                        "rules" => "permit_empty|string|max_length[65535]",
                        "errors" => [
                            "string"     => "La recette doit être une chaîne de caractères",
                            "max_length" => "La recette est trop longue"
                        ]
                    ],
                    "portions" => [
                        "label" => "Nombre de personnes",
                        "rules" => "required|integer|greater_than_equal_to[1]|less_than_equal_to[1000]",
                        "errors" => [
                            "required"           => "Le nombre de personnes est requis",
                            "integer"            => "Le nombre de personnes doit être un entier",
                            "greater_than_equal_to" => "Le nombre de personnes doit être au moins 1",
                            "less_than_equal_to" => "Le nombre de personnes ne peut pas dépasser 1000"
                        ]
                    ],
                    "difficulty" => [
                        "label" => "Difficulté",
                        "rules" => "required|in_list[easy,medium,difficult]",
                        "errors" => [
                            "required" => "La difficulté est requise",
                            "in_list"  => "La difficulté doit être : facile, moyen ou difficile"
                        ]
                    ],
                    "category_id" => [
                        "label" => "Catégorie",
                        "rules" => "required|integer|greater_than_equal_to[1]",
                        "errors" => [
                            "required" => "La catégorie est requise",
                            "integer"  => "Catégorie invalide",
                        ]
                    ],
                    "tags" => [
                        "label" => "Tags",
                        "rules" => "permit_empty",
                    ],
                ];
                //dd($this->request->getPost('difficulty'));
                if (!$this->validate($rules)) {
                    //dd($this->validator->getErrors());
                    return view('Recipe/create-recipe', [
                        'errors'             => $this->validator->getErrors(),
                        'tags'               => $tagModel->findAll(),
                        'categories'         => $categoryModel->findAll(),
                        'units'              => array_column($unitModel->findAll(), 'name'), //filtre la col name 
                        'categories_ing_db'  => $ingredientModel->getCategory()
                    ]);
                }
                // gestion de l'image (à externaliser plus tard)
                $image = $this->request->getFile('image_url');
                if ($image && $image->isValid() && !$image->hasMoved()) { //car ne peut être bougée qu'une seule fois et l'a déjà été pour stockage temporaire
                    $newName = $image->getRandomName();
                    $image_path = 'uploads/recipes/' . $newName;
                    $image->move(ROOTPATH . 'public/uploads/recipes', $newName);
                } else {
                    $image_path = null; // ou une image par défaut
                }

                // Purification du html de quill
                $config = HTMLPurifier_Config::createDefault();
                $purifier = new HTMLPurifier($config);
                $content = $purifier->purify($this->request->getPost('content'));
                $data = [
                    'user_id'           => session()->get('user_id'),
                    'title'             => $this->request->getPost('title'),
                    'image_url'         => $image_path,
                    'prep_time' => $this->request->getPost('prep_time') ?: null,
                    //ternaire syntaxe simplifiée = $this->request->getPost('temps_preparation')? $this->request->getPost('temps_preparation'): null
                    'cook_time'     => $this->request->getPost('cook_time') ?: null,
                    'content'           => $content,
                    'portions'      => $this->request->getPost('portions'),
                    'difficulty'        => $this->request->getPost('difficulty'),
                    'status'            => 'pending',
                    'views'           => 0,
                ];

                //gestion des tables de liaison:
                $recipe_id = $this->model->createRecipe($data); //ici insertion en base
                //dd($recipe_id);
                $db = \Config\Database::connect();
                $category_id = $this->request->getPost('category_id');
                if ($category_id) {
                    $db->table('recipe_categories')->insert([
                        'recipe_id'   => $recipe_id,
                        'category_id' => $category_id
                    ]);
                }
                $tag_ids = $this->request->getPost('tags');
                //dd($tag_ids);
                if ($tag_ids) {

                    // force en tableau
                    $tag_ids = is_array($tag_ids) ? $tag_ids : [$tag_ids];
                    foreach ($tag_ids as $tag_id) {
                        $db->table('recipe_tags')->insert([
                            'recipe_id' => $recipe_id,
                            'tag_id'     => $tag_id
                        ]);
                    }
                }
                // Sauvegarde des ingrédients
                $ingredients = $this->request->getPost('ingredients');
                //dd($ingredients);
                if ($ingredients) {
                    foreach ($ingredients as $ingredient) {
                        $name = ucfirst(strtolower(trim($ingredient['name'])));
                        //éviter les doublons d'orthographe différente:ucfirst normalise avec une capitale en premier
                        if (empty($name)) continue; // on saute les lignes vides
                        //  on cherche si l'ingrédient existe déjà
                        $existing = $db->table('ingredients')
                            ->where('name', $name)
                            ->get()
                            ->getRowArray();
                        if ($existing) {
                            // si existe : on récupère son id
                            $ingredient_id = $existing['id']; //syntaxe array car getRowArray() ci-dessus
                        } else {
                            //sinon on l'insère
                            $db->table('ingredients')->insert([
                                'name'       => $name,
                                'category' => $ingredient['category']
                            ]);
                            $ingredient_id = $db->insertID();
                        }
                        // insertion dans recette_ingredients
                        $db->table('recipe_ingredients')->insert([
                            'recipe_id'    => $recipe_id,
                            'ingredient_id' => $ingredient_id,
                            'quantity'      => $ingredient['quantity'] ?: null,
                            'unit'         => $ingredient['unit'] ?: null
                        ]);
                    }
                }


                return redirect()->to('/recipe-index')->with('success', 'Recette créée avec succès !');
            } else {
                return redirect()->to('/')->with('error', 'Accès refusé.');
            }
        }
    }

    public function updateRecipe(int $id)
    {
        if ($this->request->is('get')) //ou is('post')===false
        {
            $recipe = $this->model->getRecipe($id); //car find() na fait pas les jointures !
            $tagModel = model('TagModel');
            $categoryModel = model('CategoryModel');
            $ingredientModel = model('IngredientModel');
            $recipe_tag_ids = $this->model->getRecipeTagIds($id);

            return view('Recipe/update-recipe', [
                'recipe' => $recipe,
                'tags' => $tagModel->findAll(),
                'categories' => $categoryModel->findAll(),
                'ingredients' => $this->model->getRecipeIngredients($id),
                'units' => array_column(model('UnitModel')->findAll(), 'name'),
                'recipe_tag_ids' => $recipe_tag_ids

            ]);
        } else { //si pas get, post donc traitement
            $user_id = session()->get('user_id');
            // dd($id,$this->request->getPost());//pour voir!
            $rules = [
                "title" => [
                    "label" => "Titre",
                    "rules" => "required|min_length[2]|max_length[50]",
                    "errors" => [
                        "required"   => "Titre requis",
                        "min_length" => "Titre trop court",
                        "max_length" => "Titre trop long",
                    ]
                ],
                "image_url" => [
                    "label" => "Image",
                    "rules" => "permit_empty|is_image[image_url]|max_size[image_url,2048]|mime_in[image_url,image/jpg,image/jpeg,image/png]",
                    "errors" => [
                        "is_image" => "Le fichier doit être une image",
                        "max_size" => "L'image ne doit pas dépasser 2 Mo",
                        "mime_in"  => "Le fichier doit être au format JPG ou PNG"
                    ]
                ],
                "prep_time" => [
                    "label" => "Temps de préparation",
                    "rules" => "permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[2880]",
                    "errors" => [
                        "integer"               => "Le temps de préparation doit être un nombre entier",
                        "greater_than_equal_to" => "Le temps de préparation doit être d'au moins 1 minute",
                        "less_than_equal_to"    => "Le temps de préparation ne peut pas dépasser 2880 minutes (48h)"
                    ]
                ],
                "cook_time" => [
                    "label" => "Temps de cuisson",
                    "rules" => "permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[2880]",
                    "errors" => [
                        "integer"               => "Le temps de cuisson doit être un nombre entier",
                        "greater_than_equal_to" => "Le temps de cuisson doit être d'au moins 1 minute",
                        "less_than_equal_to"    => "Le temps de cuisson ne peut pas dépasser 2880 minutes (48h)"
                    ]
                ],
                "content" => [
                    "label" => "Étapes de la recette",
                    "rules" => "permit_empty|string|max_length[65535]",
                    "errors" => [
                        "string"     => "La recette doit être une chaîne de caractères",
                        "max_length" => "La recette est trop longue"
                    ]
                ],
                "portions" => [
                    "label" => "Nombre de personnes",
                    "rules" => "required|integer|greater_than_equal_to[1]|less_than_equal_to[1000]",
                    "errors" => [
                        "required"           => "Le nombre de personnes est requis",
                        "integer"            => "Le nombre de personnes doit être un entier",
                        "greater_than_equal_to" => "Le nombre de personnes doit être au moins 1",
                        "less_than_equal_to" => "Le nombre de personnes ne peut pas dépasser 1000"
                    ]
                ],
                "difficulty" => [
                    "label" => "Difficulté",
                    "rules" => "required|in_list[facile,moyen,difficile]",
                    "errors" => [
                        "required" => "La difficulté est requise",
                        "in_list"  => "La difficulté doit être : facile, moyen ou difficile"
                    ]
                ],


            ];
            if (!$this->validate($rules)) {
                dd($this->validator->getErrors());
                return view('Recipe/update-recipe', [
                    'errors' => $this->validator->getErrors(),
                    'recipe' => $this->model->getRecipe($id),
                    'tags' => model('TagModel')->findAll(),
                    'recipe_tag_ids' => $this->model->getRecipeTagIds($id),
                    'categories' => model('CategoryModel')->findAll(),
                    'ingredients' => $this->model->getRecipeIngredients($id),
                    'units' => array_column(model('UnitModel')->findAll(), 'name'),
                    'categories_ing_db' => model('IngredientModel')->getCategory()
                ]);
            }
            $image = $this->request->getFile('image_url');
            //dd($image->isValid(), $image->hasMoved(), $image->getError());           
            if ($image && $image->isValid() && !$image->hasMoved()) //ci4 déplace du dossier temporaire vers le dossier final,
            // et l'image ne peut être déplacée qu'une fois, donc on évite d'essayer de déplacer un fichier qui l'a déjà été.
            {
                $newName = $image->getRandomname(); //nom aléatoire unique pour éviter d'écraser un autre fichier.
                $image_path = 'uploads/recipes/' . $newName;
                $image->move(ROOTPATH . 'public/uploads/recipes', $newName); //déplace du dossier temporaire de ci4 vers uploads avc son nouveau nom
            } else {
                //dd($id);
                //get a déjà $recipe mais pas post donc :
                $recipe = $this->model->find($id);
                $image_path = $recipe->image_url;
            }



            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $content = $purifier->purify($this->request->getPost('content'));
            $data = [
                'user_id'           => 3, //toujours provisoire
                'title'             => $this->request->getPost('title'),
                'image_url'         => $image_path,
                'prep_time' => $this->request->getPost('prep_time') ?: null,
                'cook_time'     => $this->request->getPost('cook_time') ?: null,
                'content'           => $content,
                'portions'      => $this->request->getPost('portions'),
                'difficulty'        => $this->request->getPost('difficulty'),
                'status'            => 'pending',
            ];

            //dd($image->isValid(), $image->hasMoved(), $image->getError());

            //pour les tables de liaison:
            $this->model->update($id, $data);
            //dd($result, $this->model->db->affectedRows());
            //$this->model->updateRecipe($id, $data);


            $recipe_id = $id; //pour les tables intermédiaires
            $db = \Config\Database::connect();
            $category_id = $this->request->getPost('category_id');
            $db->table('recipe_categories')->where('recipe_id', $recipe_id)->delete(); //supp avant réinsertion
            if ($category_id) {
                $db->table('recipe_categories')->insert([
                    'recipe_id' => $recipe_id,
                    'category_id' => $category_id
                ]);
            }

            $ingredients = $this->request->getPost('ingredients');
            $db->table('recipe_ingredients')->where('recipe_id', $recipe_id)->delete(); //on supprime les anciens ingrédients
            if ($ingredients) {
                foreach ($ingredients as $ingredient) {
                    $name = ucfirst(strtolower(trim($ingredient['name'])));
                    if (empty($name)) continue;

                    $existing = $db->table('ingredients')
                        ->where('name', $name)
                        ->get()
                        ->getRowArray();

                    if ($existing) {
                        $ingredient_id = $existing['id'];
                    } else {
                        $db->table('ingredients')->insert([
                            'name' => $name,
                            'category' => $ingredient['category']
                        ]);
                        $ingredient_id = $db->insertID();
                    }
                    $db->table('recipe_ingredients')->insert([
                        'recipe_id'    => $recipe_id,
                        'ingredient_id' => $ingredient_id,
                        'quantity'      => $ingredient['quantity'] ?: null,
                        'unit'         => $ingredient['unit'] ?: null
                    ]);
                }
            }
            //partie ajoutée car les tags s'acumulaient à chaque update
            $tag_ids = $this->request->getPost('tags');
            $db->table('recipe_tags')->where('recipe_id', $recipe_id)->delete();
            if ($tag_ids) {
                $tag_ids = is_array($tag_ids) ? $tag_ids : [$tag_ids];
                foreach ($tag_ids as $tag_id) {
                    $db->table('recipe_tags')->insert([
                        'recipe_id' => $recipe_id,
                        'tag_id'    => $tag_id
                    ]);
                }
            }
            $user_id = session()->get('user_id');
            return redirect()->to('profile/' . $user_id)->with('success', 'Recette modifiée avec succès !');
            // return redirect()->to('Recipe/recipes-index')->with('success', 'Recette modifiée avec succès !');
        }
    }

    public function deleteRecipe(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('Admin/recipes-index')->with('success', 'Recette supprimée');
    }
}
