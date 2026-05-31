<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="<?= base_url('css/quill.css') ?>" rel="stylesheet">
<link href="<?= base_url('./css/recipes/create-recipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<h2 class="text-center">Proposez une recette</h2>

<?php
$title = [
    'name' => 'title',
    'id' => 'title',
    'value' => set_value('title'),
    'class' => 'form-control w-50'
];
$image = [
    'name' => 'image_url',
    'id' => 'image_url',
    'value' => set_value('image_url'),
    'class' => 'form-control w-50'
];
$pt = [
    'name' => 'prep_time',
    'id' => 'prep_time',
    'value' => set_value('prep_time'),
    'class' => 'form-control w-50'
];
$ct = [
    'name' => 'cook_time',
    'id' => 'cook_time',
    'value' => set_value('cook_time'),
    'class' => 'form-control w-50'
];

$portions = [
    'name' => 'portions',
    'id' => 'portions',
    'value' => set_value('portions'),
    'class' => 'form-control w-50'
];

$diff_options = [
    ''          => '-- Choisir --',
    'easy'    => 'Facile',
    'medium'     => 'Moyen',
    'difficult' => 'Difficile',
];
$cat = [
    'name'  => 'categoriyid',
    'id'    => 'category_id',
    'class' => 'form-select w-50'
];
/* $options_ingredients = [
    ''          => '-- Catégorie --',
    'viandes'   => 'Viandes',
    'poissons'  => 'Poissons',
    'oeufs'     => 'Oeufs',
    'legumes'   => 'Légumes',
    'fruits'    => 'Fruits',
    'feculents' => 'Féculents',
    'cereales'  => 'Farines et céréales',
    'laitiers'  => 'Produits laitiers',
    'epices'    => 'Épices & herbes',
    'sucrants'  => 'Sucre et édulcorants',
    'epicerie_sucree' => 'Épicerie sucrée',
    'matieres_grasses' => 'Matières grasses',
    'liquides'  => 'Liquides',
    'autres'    => 'Autres'
];
 */
//ingredients_categories
$options_ingredients = ['' => '-- Catégorie --'];
foreach ($categories_ing_db as $cat_ing) {
    
       $options_ingredients[$cat_ing->name] = $cat_ing->name; 
}
//recette_categorie
$options_categories = ['' => 'choisir une catégorie']; //s'affiche par défaut
foreach ($categories as $category) {
    $options_categories[$category->id] = $category->name; 
}
?>
<?= validation_list_errors() ?>
<?= form_open_multipart('add-recipe', ['id' => 'form']) ?>
<div class="recipe-form">
    <!-- $status et $views gérées ds ctrlr -->
    <div class="infos">
        

        <label for="title">Titre</label>
        <?= form_input($title) ?>
        <?= validation_show_error('title') ?>

        <label for="image_url">Illustration</label>
        <?= form_upload($image) ?>
        <?= validation_show_error('image_url') ?>

        <label for="prep_time">Temps de préparation</label>
        <?= form_input($pt) ?>
        <?= validation_show_error('prep_time') ?>

        <label for="cook_time">Temps de cuisson</label>
        <?= form_input($ct) ?>
        <?= validation_show_error('cook_time') ?>

        <label for="portions">Nombre de personnes</label>
        <?= form_input($portions) ?>
        <?= validation_show_error('portions') ?>

        <label for="difficulty">Difficulté</label>
        <?= form_dropdown('difficulty', $diff_options, set_value('difficulty'), ['id' => 'difficulty', 'class' => 'form-select w-50']) ?>
        <?= validation_show_error('difficulty') ?>

        <label for="categorie_id">Catégorie</label>
        <?= form_dropdown('category_id', $options_categories, set_value('category_id'), $cat) ?>
        <?= validation_show_error('category_id') ?>

        <label>Tags</label>
        <div class="d-flex flex-wrap gap-3">
            <?php foreach ($tags as $tag) : ?>
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="tags"
                        value="<?= $tag->id ?>"
                        id="tag_<?= $tag->id ?>"
                        class="form-check-input"
                        <?= in_array($tag->id, (array) set_value('tags')) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="tag_name" <?= $tag->id ?>">
                        <?= $tag->name ?>
                    </label>
                </div>
            <?php endforeach ?>
        </div>
        <?= validation_show_error('tags') ?>

        <label>Ingrédients</label>
        <div id="ingredients-container">
            <div class="ingredient-row gap-2 mb-2">
                <?php
                $ing_name = [
                    'name'        => 'ingredients[0][name]',
                    'type'        => 'hidden',
                    'id'          => 'ing-name-0'
                ];
                $ing_qty = [
                    'name'        => 'ingredients[0][quantity]',
                    'type'        => 'hidden',
                    'id'          => 'ing-qty-0'
                ];
                $ing_unit = [
                    'name'        => 'ingredients[0][unit]',
                    'type'        => 'hidden',
                    'id'          => 'ing-unit-0'
                ];
                ?>

                <!-- Champ visible unique -->
                <input type="text"
                    class="form-control ingredient-input"
                    placeholder="Ex: 200g farine, 2 oeufs..."
                    data-index="0">

                <!-- Champs cachés qui stockent les 3 valeurs -->
                <?= form_input($ing_name) ?>
                <?= form_input($ing_qty) ?>
                <?= form_input($ing_unit) ?>

                <!-- Aperçu du parsing -->
                <small class="text-muted parsing-preview w-100"></small>

                <?= form_dropdown('ingredients[0][category]', $options_ingredients, '', ['class' => 'form-select w-25']) ?>
                <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mt-2 mb-3" id="ajouter-ingredient">Ajouter un ingrédient</button><br>
    </div>

    <div class="editeur">
        <label for="content">
            <h2>Votre Recette</h2>
        </label>
        <div id="toolbar">
            <button class="ql-bold"></button>
            <button class="ql-italic"></button>
            <button class="ql-underline"></button>
            <button class="ql-list" value="ordered"></button>
            <button class="ql-list" value="bullet"></button>
        </div>
        <div id="editor"></div>
        <input type="hidden" name="content" id="content" value="<?= set_value('content') ?>">

        <button type="submit" class="btn btn-primary">Envoyer</button>
        
    </div>
</div>
<?= form_close() ?>

<?= $this->endSection() ?>
<?= $this->section('customJs') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    // Variables php vers js, déclarées ici car le fichier .js ne peut pas contenir du php
    const categoriesIngredient = <?= json_encode($options_ingredients) ?>;
    const units = <?= json_encode($units) ?>;
</script>
<script src="/js/create-recipe.js"></script>
<?= $this->endSection() ?>




