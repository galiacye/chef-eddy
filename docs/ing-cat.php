pour des cat d'ing dynamiques :

controller Recipe: 
<?php
public function createRecipe()
{
    if ($this->request->is('post') === false) {
        $tagModel       = new TagModel();
        $categoryModel  = new CategoryModel(); // Catégories de RECETTES
        $unitModel      = new UnitModel();
        $ingModel       = new IngredientModel(); //  modèle d'ingrédients

        return view('Recipe/create-recipe', [
            'tags'               => $tagModel->findAll(),
            'categories'         => $categoryModel->findAll(),
            'unites'             => array_column($unitModel->findAll(), 'nom'),
            // AJOUT de  CECI :
            'categories_ing_db'  => $ingModel->getCategory() 
        ]);
    }
    // ... reste du code
}?>

vue createRecipe : 

<?php
 // Remplacer l'ancien $options_ingredients par celui-ci :
$options_ingredients = ['' => '-- Catégorie --'];
foreach ($categories_ing_db as $cat_ing) {
    // On utilise le nom comme clé  attendue en base, 
    $options_ingredients[$cat_ing->nom] = $cat_ing->nom; 
}?>

bloc de validation : 

<?php
if (!$this->validate($rules)) {
    $ingModel = new IngredientModel(); // Nécessaire ici aussi
    return view('Recipe/create-recipe', [
        'errors'             => $this->validator->getErrors(),
        'tags'               => (new TagModel())->findAll(),
        'categories'         => (new CategoryModel())->findAll(),
        'unites'             => array_column((new UnitModel())->findAll(), 'nom'),
        'categories_ing_db'  => $ingModel->getCategory() // Re-chargement ici
    ]);
}