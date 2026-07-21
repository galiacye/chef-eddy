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
    'class' => 'form-control w-100 w-lg-50 shadow'
];
$image = [
    'name' => 'image_url',
    'id' => 'image_url',
    'value' => set_value('image_url'),
    'class' => 'form-control w-50 shadow'
];
$pt = [
    'name' => 'prep_time',
    'id' => 'prep_time',
    'value' => set_value('prep_time'),
    'class' => 'form-control w-50 shadow'
];
$ct = [
    'name' => 'cook_time',
    'id' => 'cook_time',
    'value' => set_value('cook_time'),
    'class' => 'form-control w-50 shadow'
];

$portions = [
    'name' => 'portions',
    'id' => 'portions',
    'value' => set_value('portions'),
    'class' => 'form-control w-50 shadow'
];

$diff_options = [
    ''          => '-- Choisir --',
    'easy'    => 'Facile',
    'medium'     => 'Moyen',
    'difficult' => 'Difficile'
];
$cat = [
    'name'  => 'category_id',
    'id'    => 'category_id',
    'class' => 'form-select w-50 shadow'
];

//ingredients_categories appelé $options_ingredients pour éviter
// la confusion avec les catégories de recettes
$options_ingredients = ['' => ' Catégorie '];
foreach ($categories_ing_db as $cat_ing) {

    $options_ingredients[$cat_ing->id] = esc($cat_ing->name);
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
<div class="recipe-form px-1 px-md-3 px-lg-5">
    <!--<div class="row">
    <div class="col-12 col-md-6"> pour diviser row en deux pour image éventuelle-->


    <!-- $status et $views gérées ds controller -->
    <div class="infos">

        <!--form_input(), form_upload(), form_dropdown(), validation_show_error(), 
validation_list_errors() échappent donc esc est inutile ici-->
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

        <label class="form-label mt-4 mb-1">Tags</label>
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

        <label class="form-label mt-4 mb-1">Ingrédients</label>
        <div id="ingredients-container" class="w-50">
            <?php
            $old_ingredients = $old_ingredients ?? [];
            if (empty($old_ingredients)) : ?>
                <!-- 6 lignes vides par défaut au premier chargement -->
                <?php for ($index = 0; $index < 6; $index++) : ?>
                    <div class="ingredient-row d-flex gap-2 mb-2">
                        <input type="text"
                            class="form-control ingredient-input shadow"
                            placeholder="Ex: 200g farine, 2 oeufs..."
                            data-index="<?= $index ?>">

                        <input type="hidden" name="ingredients[<?= $index ?>][name]" id="ing-name-<?= $index ?>">
                        <input type="hidden" name="ingredients[<?= $index ?>][quantity]" id="ing-qty-<?= $index ?>">
                        <input type="hidden" name="ingredients[<?= $index ?>][unit]" id="ing-unit-<?= $index ?>">
                        <small class="text-muted parsing-preview w-50"></small>
                        <?= form_dropdown('ingredients[' . $index . '][category_id]', $options_ingredients, '', ['class' => 'form-select w-50 shadow']) ?>
                        <button type="button" class="btn btn-coralPlus shadow mt-2 supprimer-ligne">Supprimer</button>
                    </div>
                <?php endfor ?>
            <?php else : ?>
                <!-- restauration après échec validation -->
                <?php foreach ($old_ingredients as $index => $ing) : ?>
                    <!-- ... inchangé ... -->
                <?php endforeach ?>
            <?php endif ?>
        </div>
        <button type="button" class="btn btn-ajout mb-4 shadow" id="ajouter-ingredient">Ajouter un ingrédient</button><br>
    </div>
   

    <div class="editeur w-100 m-0">
        <!--contenu copié en hidden dans #content avant soumission (voir create-recipe.js) -->
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
        <div id="editor" class="w-100 m-0"></div>
        <input type="hidden" name="content" id="content" value="<?= esc(set_value('content')) ?>">
        <!--tjrs esc-->
        <div class="bouton">
            <button type="submit" class="btn btn-blue m-4">Envoyer</button>
        </div>
    </div>
</div>
<?= form_close() ?>
<?= $this->endSection() ?>
<?= $this->section('customJs') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    // Variables PHP converties au format JSON afin d'être exploitées en JavaScript, create-recipe.js ne pouvant contenir de php
    const categoriesIngredient = <?= json_encode($options_ingredients, JSON_HEX_TAG | JSON_HEX_AMP) ?>;
    const units = <?= json_encode($units, JSON_HEX_TAG | JSON_HEX_AMP) ?>;
    // JSON_HEX_TAG encode les caractères < et > pour éviter l'injection de balises HTML dans le script.
</script>
<script src="/js/create-recipe.js"></script>
<?= $this->endSection() ?>