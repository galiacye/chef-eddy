<?php

/**
 * @var object $recipe
 * @var object $categories
 * @var int $id
 * @var object $ingredients
 * @var object $ing
 * @var object $tags
 */
?>
<?= $this->extend('layout') ?>
<?= $this->section('title') ?>
<title>Modifier une recette</title>
<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>

<link href="<?= base_url('./css/recipes/createRecipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<h2 class="text-center">Modifier une de vos recettes</h2>

<?php
$title = [
    'name' => 'title',
    'id' => 'title',
    'value' => set_value('title', isset($recipe->title) ? $recipe->title : ''),
    'class' => 'form-control w-50'
];
$image = [
    'name' => 'image_url',
    'id' => 'image_url',
    'value' => set_value('image_url', isset($recipe->image) ? $recipe->image_url : ''),
    'class' => 'form-control w-50'
];
$pt = [
    'name' => 'prep_time',
    'id' => 'prep_time',
    'value' => set_value('prep_time', isset($recipe->prep_time) ? $recipe->prep_time : ''),
    'class' => 'form-control w-50'
];
$ct = [
    'name' => 'cook_time',
    'id' => 'cook_time',
    'value' => set_value('cook_time', isset($recipe->cook_time) ? $recipe->cook_time : ''),
    'class' => 'form-control w-50'
];

$portions = [
    'name' => 'portions',
    'id' => 'portions',
    'value' => set_value('portions', isset($recipe->portions) ? $recipe->portions : ''),
    'class' => 'form-control w-50'
];

$diff_options = [
    ''          => '-- Choisir --',
    'easy'    => 'Facile',
    'medium'     => 'Moyen',
    'difficult' => 'Difficile',
];
$cat = [
    'name'  => 'category_id',
    'id'    => 'category_id',
    'class' => 'form-select w-50'
];

//form_dropdown génère le html select à partir du tab $options_categories
$options_categories = ['' => 'choisir une catégorie']; //s'affiche par défaut
foreach ($categories as $category) {
    $options_categories[$category->id] = $category->name; //valeur envoyée en base(id)  = ce que user voit(nom renvoyé par la base pour id)
}
?>
<?= form_open_multipart('update-recipe/' . $recipe->id, ['id' => 'form']) ?>
<div class="recipe-form">
    <!-- $status et $views gérées ds ctrlr -->
    <div class="infos">

        <label for="title">Title</label>
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
        <?= form_dropdown(
            'difficulty',
            $diff_options,
            set_value('difficulty', isset($recipe->difficulty) ? $recipe->difficulty : ''), //set_value vient en 3ème argument
            //ou set_value('difficulty', $recipe->difficulty ?? '')
            ['id' => 'difficulty', 'class' => 'form-select w-50']
        ) ?>
        <?= validation_show_error('difficulty') ?>

        <label for="category_id">Catégorie</label>
        <?= form_dropdown(
            'category_id',
            $options_categories,
            set_value('category_id', isset($recipe->category_id) ? $recipe->category_id : ''),
            $cat
        ) ?>
        <?= validation_show_error('category_id') ?>

        <label>Tags</label>
        <div class="tags-container d-flex flex-wrap gap-2">
            <?php foreach ($tags as $tag) : ?>
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="tags[]"
                        id="tag-<?= $tag->id ?>"
                        value="<?= $tag->id ?>"
                        class="form-check-input"
                        <?= in_array($tag->id, $recipe_tag_ids ?? []) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="tag-<?= $tag->id ?>"><?= esc($tag->name) ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <?= validation_show_error('tags') ?>

        <label>Ingrédients</label>
        <!--ici pas de champs unique, posssibilité de retoucher grammage uniquement, par ex-->
        <div id="ingredients-container">
            <?php foreach ($ingredients as $index => $ing) : ?>
                <div class="ingredients-row gap-2 mb-2">
                    <input type="text" name="ingredients[<?= $index ?>][name]" value="<?= esc($ing->name) ?>" placeholder="Nom" class="form-control">
                    <input type="number" name="ingredients[<?= $index ?>][quantity]" value="<?= esc($ing->quantity) ?>" placeholder="Quantité" class="form-control w-25">
                    <input type="text" name="ingredients[<?= $index ?>][unit]" value="<?= esc($ing->unit) ?>" placeholder="Unité (g, ml…)" class="form-control w-25">
                    <!--form_dropdown gère champs simples, pas les noms indexés dynamiquement comme ingredient[index][categorie].-->
                    <select name="ingredients[<?= $index ?>][category_id]" class="form-select w-25">
                        <option value="">-- Catégorie --</option>
                        <?php foreach ($categories_ing_db as $cat_ing): ?>
                            <option value="<?= $cat_ing->id ?>"
                                <?= isset($ing->category_id) && $ing->category_id == $cat_ing->id ? 'selected' : '' ?>>
                                <?= esc($cat_ing->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
                </div>
            <?php endforeach; ?>
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
    <input type="hidden" name="content" id="content" value="<?= set_value('content', esc($recipe->content) ?? '') ?>">
    <!-- $recipe->contenu pr que l'ancien contenu s'affiche -->
    <button type="submit" class="btn btn-primary">Envoyer</button>

</div>
</div>
<?= form_close() ?>
<form action="<?= base_url('/delete-recipe/' . $recipe->id) ?>" method="post">
    <?= csrf_field() ?>
    <button type="submit" class="btn btn-danger"
        onclick="return confirm('Supprimer définitivement cette recette?')">Supprimer</button>
</form>



<?= $this->section('customJs') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<?php
$cats_js = [];
foreach ($categories_ing_db as $c) {
    $cats_js[$c->id] = $c->name;//def $cats_js comme objet js
}
?>
<script>
   const categoriesIngredients = <?= json_encode($cats_js) ?>;
    let index = <?= !empty($ingredients) ? count($ingredients) : 1 ?>
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const quill = new Quill('#editor', {
            modules: { //relie la toolbar qui est en dehors du form
                toolbar: '#toolbar'
            },
            placeholder: 'Écrivez votre recette ici...',
            theme: 'snow',
        });
        const existingContent = document.getElementById('content').value;
        if (existingContent) {
            quill.root.innerHTML = existingContent;
        }

        // Ajouter les tooltips en français
        document.querySelector('.ql-bold').setAttribute('title', 'Gras');
        document.querySelector('.ql-italic').setAttribute('title', 'Italique');
        document.querySelector('.ql-underline').setAttribute('title', 'Souligné');
        document.querySelector('.ql-list[value="ordered"]').setAttribute('title', 'Liste numérotée');
        document.querySelector('.ql-list[value="bullet"]').setAttribute('title', 'Liste à puces');

        //bouton ajouter un ing:

        document.getElementById('ajouter-ingredient').addEventListener('click', () => {
            const container = document.getElementById('ingredients-container');
            const row = document.createElement('div');
            row.classList.add('ingredients-row', 'gap-2', 'mb-2');

            const options = Object.entries(categoriesIngredients)
                .map(([val, label]) => `<option value="${val}">${label}</option>`)
                .join('');

            row.innerHTML = `
        <input type="text"   name="ingredients[${index}][name]"      placeholder="Nom"            class="form-control">
        <input type="number" name="ingredients[${index}][quantity]" placeholder="Quantité"       class="form-control w-25">
        <input type="text"   name="ingredients[${index}][unit]"    placeholder="Unité (g, ml…)" class="form-control w-25">
        <select name="ingredients[${index}][category_id]" class="form-select w-25">${options}</select>
        <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
    `;
            container.appendChild(row);
            index++;
        });

        document.getElementById('ingredients-container').addEventListener('click', (e) => {
            if (e.target.classList.contains('supprimer-ligne')) {
                const rows = document.querySelectorAll('.ingredients-row');
                if (rows.length > 1) {
                    e.target.closest('.ingredients-row').remove();
                } else {
                    alert('Il faut au moins un ingrédient !');
                }
            }
        });

        // Gestion de la soumission du formulaire
        document.getElementById('form').addEventListener('submit', (e) => {
            const html = quill.root.innerHTML;
            document.getElementById('content').value = html;

            // Vérifier que ce n'est pas vide
            const text = quill.getText().trim();
            if (text.length === 0) {
                e.preventDefault(); //empêche l'envoi par défaut
                alert('Veuillez remplir le formulaire avant d\'envoyer');
            }
        });
    })
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>