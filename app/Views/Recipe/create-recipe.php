<?= $this->extend('layout') ?>
<?= $this->section('title') ?>
<title>Proposer une recette</title>
<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="<?= base_url('css/quill.css') ?>" rel="stylesheet">
<link href="<?= base_url('./css/recipes/create-recipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<h2 class="text-center mt-4">Proposez une recette</h2>

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

//ingredients_categories appelé $options_ingredients pour éviter
// la confusion avec les catégories de recettes
$options_ingredients = ['' => ' Catégorie '];
foreach ($categories_ing_db as $cat_ing) {

    $options_ingredients[$cat_ing->name] = esc($cat_ing->name);
}
//recette_categorie
$options_categories = ['' => 'choisir une catégorie']; //s'affiche par défaut
foreach ($categories as $category) {
    $options_categories[$category->id] = esc($category->name);
}
?>
<?= validation_list_errors() ?>
<!--form_open_multipart est obligatoire dès qu'un input type = file 
(ici pour charger l'image-->
<?= form_open_multipart('add-recipe', ['id' => 'form']) ?>
<div class="recipe-form px-5">
    <!--<div class="row">
    <div class="col-12 col-md-6"> pour diviser row en deux pour image éventuelle-->


    <!-- $status et $views gérées ds controller -->
    <div class="infos">

<!--form_input(), form_upload(), form_dropdown(), validation_show_error(), 
validation_list_errors() échappent déjà : esc est inutile ici-->
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
        <div class="d-flex flex-wrap gap-3 w-50">
            <?php foreach ($tags as $tag) : ?>
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="tags[]"
                        value="<?= (int)$tag->id ?>"
                        id="tag_<?= (int)$tag->id ?>"
                        class="form-check-input"
                        <?= in_array($tag->id, (array) set_value('tags')) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="tag_name" <?= $tag->id ?>">
                        <!--<label class="form-check-label" for="tag_<?= (int)$tag->id ?>"> sinon html invalide ?-->
                        <?= esc($tag->name) ?>
                    </label>
                </div>
            <?php endforeach ?>
        </div>
        <?= validation_show_error('tags') ?>

        <label>Ingrédients</label>
        <div id="ingredients-container" class="w-50">
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
                ?>     <!-- champ unique visible:-->
               <input type="text"  
                    class="form-control w-50 ingredient-input"
                    placeholder="Ex: 200g farine, 2 oeufs..."
                    data-index="0">
                <!-- champs cachés qui stockent les 3 valeurs -->
                <?= form_input($ing_name) ?>
                <?= form_input($ing_qty) ?>
                <?= form_input($ing_unit) ?>
                <!-- aperçu du parsing -->
                <small class="text-muted parsing-preview w-50"></small>

                <?= form_dropdown('ingredients[0][category]', $options_ingredients, '', ['class' => 'form-select w-50']) ?>
                <button type="button" class="btn btn-danger supprimer-ligne">X</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mt-2 mb-3" id="ajouter-ingredient">Ajouter un ingrédient</button><br>
    </div>
    <!-- </div>
    <div class="col-12 col-md-6">
    Image 
        <div class="mb-4">
            <img
                src="<?= base_url('img/desserts/spectaculaire-cote.jpg') ?>"
                alt="Recette"
                class="img-fluid rounded shadow">
        </div>
    </div>
    </div>fermeture row-->

    <div class="editeur">
        <!--contenu copié dans #content (caché) avant soumission (voir create-recipe.js) -->
        <label for="content">
            <h2 class="m-4">Votre Recette</h2>
        </label>
        <div id="toolbar">
            <button class="ql-bold"></button>
            <button class="ql-italic"></button>
            <button class="ql-underline"></button>
            <button class="ql-list" value="ordered"></button>
            <button class="ql-list" value="bullet"></button>
        </div>
        <div id="editor"></div>
        <input type="hidden" name="content" id="content" value="<?= esc(set_value('content')) ?>">
        <!--tjrs esc-->
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </div>
</div>
<?= form_close() ?>
<?= $this->endSection() ?>
<?= $this->section('customJs') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    // Variables php injectées ici pour être utilisées dans create-recipe
    // car le fichier .js ne peut pas contenir du php
    const categoriesIngredient = <?= json_encode($options_ingredients, JSON_HEX_TAG | JSON_HEX_AMP) ?>;
    const units = <?= json_encode($units, JSON_HEX_TAG | JSON_HEX_AMP) ?>;
//JSON_HEX_TAG échappe les <> pour éviter qu'un nom d'ingrédient contenant du HTML ne s'éxécute dans le js.
</script>
<script src="/js/create-recipe.js"></script>
<?= $this->endSection() ?>