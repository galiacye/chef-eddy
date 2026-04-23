<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Models\TagModel;
use App\Models\CategoryModel;
use App\Models\IngredientModel;
use App\Models\UniteModel;
use HTMLPurifier;
use HTMLPurifier_Config;

class Recipe extends BaseController
{
    private $model;
    protected $returnType = 'object';

    public function __construct()
    {
        helper('form');

        $this->model = Model('RecipeModel');
    }

    public function editRecipe()
    {
        $uniteModel = model('UniteModel');
        $unite = array_column($uniteModel->findAll(),'nom');//array_column(tableau, 'colonne_voulue')
        if($this->request->is('post')===false){
            return view('Recipe/edit-recipe',['unite'=>$unite]);
        }
        
    }

    public function showRecipe(int $id)
    {
        $recipeModel     = model('RecipeModel');
        $tagModel = model('TagModel');
        $ingredientModel = model('IngredientModel');
        $categoryModel  = model('CategoryModel');
        
        $recipe = $recipeModel->getRecipe($id);

        //dd($recipe, $id);

        $data = [
            'recipe'      => $recipeModel->getRecipe($id),
            'tags'        => $tagModel->getRecipeTags($id),
            'ingredients' => $ingredientModel->getRecipeIngredients($id),
            'categories'  => $categoryModel->getRecipeCategory($id), // une recette peut avoir plusieurs catégories
        ];

        return view('Recipe/show-recipe', $data);
    }

    public function recipeIndex(): string
    { //avc ci4 les clés du tableau $data deviennent le nom des variables ds la vue:
        //$recipes = $this->model->getRecipeAuthor();
        //$data = ['recipes' => $recipes]; équivaut à :
        $data['recipes'] = $this->model->getRecipesWithAuthor();
        return view('Recipe/recipe-index', $data);
    }


    // createRecipe:
    // validation upload image purification Quill tables de liaison gestion ingrédients intelligente 
    public function createRecipe()
    {
        if ($this->request->is('post') === false) {
            $tagModel       = new TagModel();
            $categoryModel = new CategoryModel();

            return view('Recipe/create-recipe', [
                'tags'       => $tagModel->findAll(),
                'categories' => $categoryModel->findAll()
            ]);
        } else {
            // L'user_id vient de la session
            $user_id = session()->get('user_id');

            $rules = [
                "titre" => [
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
                "temps_preparation" => [
                    "label" => "Temps de préparation",
                    "rules" => "permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[2880]",
                    "errors" => [
                        "integer"               => "Le temps de préparation doit être un nombre entier",
                        "greater_than_equal_to" => "Le temps de préparation doit être d'au moins 1 minute",
                        "less_than_equal_to"    => "Le temps de préparation ne peut pas dépasser 2880 minutes (48h)"
                    ]
                ],
                "temps_cuisson" => [
                    "label" => "Temps de cuisson",
                    "rules" => "permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[2880]",
                    "errors" => [
                        "integer"               => "Le temps de cuisson doit être un nombre entier",
                        "greater_than_equal_to" => "Le temps de cuisson doit être d'au moins 1 minute",
                        "less_than_equal_to"    => "Le temps de cuisson ne peut pas dépasser 2880 minutes (48h)"
                    ]
                ],
                "contenu" => [
                    "label" => "Étapes de la recette",
                    "rules" => "permit_empty|string|max_length[65535]",
                    "errors" => [
                        "string"     => "La recette doit être une chaîne de caractères",
                        "max_length" => "La recette est trop longue"
                    ]
                ],
                "nb_personnes" => [
                    "label" => "Nombre de personnes",
                    "rules" => "required|integer|greater_than_equal_to[1]|less_than_equal_to[1000]",
                    "errors" => [
                        "required"           => "Le nombre de personnes est requis",
                        "integer"            => "Le nombre de personnes doit être un entier",
                        "greater_than_equal_to" => "Le nombre de personnes doit être au moins 1",
                        "less_than_equal_to" => "Le nombre de personnes ne peut pas dépasser 1000"
                    ]
                ],
                "difficulte" => [
                    "label" => "Difficulté",
                    "rules" => "required|in_list[facile,moyen,difficile]",
                    "errors" => [
                        "required" => "La difficulté est requise",
                        "in_list"  => "La difficulté doit être : facile, moyen ou difficile"
                    ]
                ],
                "categorie_id" => [
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
            if (!$this->validate($rules)) {
                return view('Recipe/create-recipe', [
                    'errors' => $this->validator->getErrors(),
                    'tags'       => (new TagModel())->findAll(),
                    'categories' => (new CategoryModel())->findAll()
                ]);
            }
            // Gestion de l'image
            $image = $this->request->getFile('image_url');
            if ($image && $image->isValid() && !$image->hasMoved()) {//car ne peut être bougée qu'une seule fois et l'a déjà été pour stockage temporaire
                $newName = $image->getRandomName();
                $image_path = 'uploads/recipes/' . $newName;
                $image->move(ROOTPATH . 'public/uploads/recipes', $newName);
            } else {
                $image_path = null; // ou une image par défaut
            }

            // Purification du HTML de Quill
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $contenu = $purifier->purify($this->request->getPost('contenu'));
            $data = [
                'user_id'           => 3, //$user_id plus tard, là on teste avec admin
                'titre'             => $this->request->getPost('titre'),
                'image_url'         => $image_path,
                'temps_preparation' => $this->request->getPost('temps_preparation') ?: null,
                //ternaire syntaxe simplifiée = $this->request->getPost('temps_preparation')? $this->request->getPost('temps_preparation'): null
                'temps_cuisson'     => $this->request->getPost('temps_cuisson') ?: null,
                'contenu'           => $contenu,
                'nb_personnes'      => $this->request->getPost('nb_personnes'),
                'difficulte'        => $this->request->getPost('difficulte'),
                'statut'            => 'En attente',
                'nb_vues'           => 0,
            ];
            //gestion des tables de liaison:
            $recipe_id = $this->model->createRecipe($data); //ici insertion en base
            $db = \Config\Database::connect();
            $categorie_id = $this->request->getPost('categorie_id');
            if ($categorie_id) {
                $db->table('recette_categories')->insert([
                    'recette_id'   => $recipe_id,
                    'categorie_id' => $categorie_id
                ]);
            }
            $tag_ids = $this->request->getPost('tags');
            if ($tag_ids) {
                foreach ($tag_ids as $tag_id) {
                    $db->table('recette_tags')->insert([
                        'recette_id' => $recipe_id,
                        'tag_id'     => $tag_id
                    ]);
                }
            }
            // Sauvegarde des ingrédients
            $ingredients = $this->request->getPost('ingredients');
            if ($ingredients) {
                foreach ($ingredients as $ingredient) {
                    $nom = ucfirst(strtolower(trim($ingredient['nom']))); //éviter les doublons d'orthographe différente
                    if (empty($nom)) continue; // on saute les lignes vides

                    // 1. Chercher si l'ingrédient existe déjà
                    $ing_existant = $db->table('ingredients')
                        ->where('nom', $nom)
                        ->get()
                        ->getRowArray();

                    if ($ing_existant) {
                        // 2a. Il existe → on récupère son id
                        $ingredient_id = $ing_existant['id']; //syntaxe array car getRowArray() ci-dessus
                    } else {
                        // 2b. Il n'existe pas → on l'insère
                        $db->table('ingredients')->insert([
                            'nom'       => $nom,
                            'categorie' => $ingredient['categorie']
                        ]);
                        $ingredient_id = $db->insertID();
                    }

                    // 3. Insérer dans recette_ingredients
                    $db->table('recette_ingredients')->insert([
                        'recette_id'    => $recipe_id,
                        'ingredient_id' => $ingredient_id,
                        'quantite'      => $ingredient['quantite'] ?: null,
                        'unite'         => $ingredient['unite'] ?: null
                    ]);
                }
            }

            return redirect()->to('/recipe-index')->with('success', 'Recette créée avec succès !');
        }
    }

    public function updateRecipe($id)
    {
        if ($this->request->is('get')) //ou is('post')===false
        {
            $recipe = $this->model->getRecipe($id); //car find() na fait pas les jointures !
            $tagModel = model('TagModel');
            $categorieModel = model('CategorieModel');
            return view('Recipe/update-recipe', [
                'recipe' => $recipe,
                'tags' => $tagModel->findAll(),
                'categories' => $categorieModel->findAll(),
                'ingredients' => $this->model->getIngredients($id)
            ]);
        } else { //si pas get, post donc traitement
            $user_id = session()->get('user_id');
            // dd($id,$this->request->getPost());//pour voir!
            $rules = [
                "titre" => [
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
                "temps_preparation" => [
                    "label" => "Temps de préparation",
                    "rules" => "permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[2880]",
                    "errors" => [
                        "integer"               => "Le temps de préparation doit être un nombre entier",
                        "greater_than_equal_to" => "Le temps de préparation doit être d'au moins 1 minute",
                        "less_than_equal_to"    => "Le temps de préparation ne peut pas dépasser 2880 minutes (48h)"
                    ]
                ],
                "temps_cuisson" => [
                    "label" => "Temps de cuisson",
                    "rules" => "permit_empty|integer|greater_than_equal_to[1]|less_than_equal_to[2880]",
                    "errors" => [
                        "integer"               => "Le temps de cuisson doit être un nombre entier",
                        "greater_than_equal_to" => "Le temps de cuisson doit être d'au moins 1 minute",
                        "less_than_equal_to"    => "Le temps de cuisson ne peut pas dépasser 2880 minutes (48h)"
                    ]
                ],
                "contenu" => [
                    "label" => "Étapes de la recette",
                    "rules" => "permit_empty|string|max_length[65535]",
                    "errors" => [
                        "string"     => "La recette doit être une chaîne de caractères",
                        "max_length" => "La recette est trop longue"
                    ]
                ],
                "nb_personnes" => [
                    "label" => "Nombre de personnes",
                    "rules" => "required|integer|greater_than_equal_to[1]|less_than_equal_to[1000]",
                    "errors" => [
                        "required"           => "Le nombre de personnes est requis",
                        "integer"            => "Le nombre de personnes doit être un entier",
                        "greater_than_equal_to" => "Le nombre de personnes doit être au moins 1",
                        "less_than_equal_to" => "Le nombre de personnes ne peut pas dépasser 1000"
                    ]
                ],
                "difficulte" => [
                    "label" => "Difficulté",
                    "rules" => "required|in_list[facile,moyen,difficile]",
                    "errors" => [
                        "required" => "La difficulté est requise",
                        "in_list"  => "La difficulté doit être : facile, moyen ou difficile"
                    ]
                ],
                "categorie_id" => [
                    "label" => "Catégorie",
                    "rules" => "required|integer|greater_than_equal_to[1]",
                    "errors" => [
                        "required" => "La catégorie est requise",
                        "integer"  => "Catégorie invalide",
                    ]
                ],

            ];
            if (!$this->validate($rules)) {
                return view('Recipe/update-recipe', [
                    'errors' => $this->validator->getErrors(),
                    'recipe' => $this->model->find($id),
                    'tags' => model('TagModel')->findAll(),
                    'categories' => model('CategorieModel')->findAll(),
                    'ingredients' => $this->model->getIngredients($id)
                ]);
            }
            $image = $this->request->getFile('image_url');
            if ($image && $image->isValid() && !$image->hasMoved()) //ci4 déplace du doss temporaire vers le doss final,
            // et l'image ne peut être déplacée qu'une fois, donc on évite d'essayer de déplacer un fichier qui l'a déjà été.
            {
                $newName = $image->getRandomname(); //nom aléatoire unique pour éviter d'écraser un autre fichier nommé "gateau.jpg"!
                $image_path = 'uploads/recipes/' . $newName;
                $image->move(ROOTPATH . 'public/uploads/recipes', $newName); //déplace du doss tempo de ci4 vers uploads avc son nouveau nom
            } else {
                //get a déjà $recipe mais pas post donc :
                $recipe = $this->model->find($id);
                $image_path = $recipe->image_url;
            }
            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);
            $contenu = $purifier->purify($this->request->getPost('contenu'));
            $data = [
                'user_id'           => 3, //toujours provisoire
                'titre'             => $this->request->getPost('titre'),
                'image_url'         => $image_path,
                'temps_preparation' => $this->request->getPost('temps_preparation') ?: null,
                'temps_cuisson'     => $this->request->getPost('temps_cuisson') ?: null,
                'contenu'           => $contenu,
                'nb_personnes'      => $this->request->getPost('nb_personnes'),
                'difficulte'        => $this->request->getPost('difficulte'),
                'statut'            => 'pending',
            ];
            //pour les tables de liaison:
            $this->model->updateRecipe($id, $data);

            // dd($id, $data); // 

            $recipe_id = $id; //pour les tables intermédiaires
            $db = \Config\Database::connect();
            $categorie_id = $this->request->getPost('categorie_id');
            $db->table('recette_categories')->where('recette_id', $recipe_id)->delete(); //supp avant réinsertion
            if ($categorie_id) {
                $db->table('recette_categories')->insert([
                    'recette_id' => $recipe_id,
                    'categorie_id' => $categorie_id
                ]);
            }

            $ingredients = $this->request->getPost('ingredients');
            $db->table('recette_ingredients')->where('recette_id', $recipe_id)->delete(); //on supprime les anciens ingr
            if ($ingredients) {
                foreach ($ingredients as $ingredient) {
                    $nom = ucfirst(strtolower(trim($ingredient['nom'])));
                    if (empty($nom)) continue;

                    $ing_existant = $db->table('ingredients')
                        ->where('nom', $nom)
                        ->get()
                        ->getRowArray();

                    if ($ing_existant) {
                        $ingredient_id = $ing_existant['id'];
                    } else {
                        $db->table('ingredients')->insert([
                            'nom' => $nom,
                            'categorie' => $ingredient['categorie']
                        ]);
                        $ingredient_id = $db->insertID();
                    }
                    $db->table('recette_ingredients')->insert([
                        'recette_id'    => $recipe_id,
                        'ingredient_id' => $ingredient_id,
                        'quantite'      => $ingredient['quantite'] ?: null,
                        'unite'         => $ingredient['unite'] ?: null
                    ]);
                }
            }
            return redirect()->to('/recipe-index')->with('success', 'Recette modifiée avec succès !');
        }
    }
}
