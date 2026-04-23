<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="<?= base_url('css/quill.css') ?>" rel="stylesheet">
<link href="<?= base_url('./css/recipes/createRecipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<h2 class="text-center">Proposez une recette</h2>

<?php
$title = [
    'name' => 'titre',
    'id' => 'titre',
    'value' => set_value('titre'),
    'class' => 'form-control w-50'
];
$image = [
    'name' => 'image_url',
    'id' => 'image_url',
    'value' => set_value('image_url'),
    'class' => 'form-control w-50'
];
$tp = [
    'name' => 'temps_preparation',
    'id' => 'temps_preparation',
    'value' => set_value('temps_preparation'),
    'class' => 'form-control w-50'
];
$tc = [
    'name' => 'temps_cuisson',
    'id' => 'temps_cuisson',
    'value' => set_value('temps_cuisson'),
    'class' => 'form-control w-50'
];

$nb_pers = [
    'name' => 'nb_personnes',
    'id' => 'nb_personnes',
    'value' => set_value('nb_personnes'),
    'class' => 'form-control w-50'
];

$diff_options = [
    ''          => '-- Choisir --',
    'facile'    => 'Facile',
    'moyen'     => 'Moyen',
    'difficile' => 'Difficile',
];
$cat = [
    'name'  => 'categorie_id',
    'id'    => 'categorie_id',
    'class' => 'form-select w-50'
];
$options_ingredients = [
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

//form_dropdown génère le html select à partir du tab $options_categories
$options_categories = ['' => 'choisir une catégorie']; //s'affiche par défaut
foreach ($categories as $categorie) {
    $options_categories[$categorie->id] = $categorie->nom; //valeur envoyée en base(id) = ce que user voit(nom renvoyé par la base pour id)
}
?>
<div class="formulaire">
    <!-- $status et $views gérées ds ctrlr -->
    <div class="infos">
        <?= form_open_multipart('add-recipe', ['id' => 'form']) ?>

        <label for="titre">Titre</label>
        <?= form_input($title) ?>
        <?= validation_show_error('titre') ?>

        <label for="image_url">Illustration</label>
        <?= form_upload($image) ?>
        <?= validation_show_error('image_url') ?>

        <label for="temps_preparation">Temps de préparation</label>
        <?= form_input($tp) ?>
        <?= validation_show_error('temps_preparation') ?>

        <label for="temps_cuisson">Temps de cuisson</label>
        <?= form_input($tc) ?>
        <?= validation_show_error('temps_cuisson') ?>

        <label for="nb_personnes">Nombre de personnes</label>
        <?= form_input($nb_pers) ?>
        <?= validation_show_error('nb_personnes') ?>

        <label for="difficulte">Difficulté</label>
        <?= form_dropdown('difficulte', $diff_options, set_value('difficulte'), ['id' => 'difficulte', 'class' => 'form-select w-50']) ?>
        <?= validation_show_error('difficulte') ?>

        <label for="categorie_id">Catégorie</label>
        <?= form_dropdown('categorie_id', $options_categories, set_value('categorie_id'), $cat) ?>
        <?= validation_show_error('categorie_id') ?>

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
                    <label class="form-check-label" for="tag_nom" <?= $tag->id ?>">
                        <?= $tag->nom ?>
                    </label>
                </div>
            <?php endforeach ?>
        </div>
        <?= validation_show_error('tags') ?>

        <label>Ingrédients</label>
        <div id="ingredients-container">
            <div class="ingredient-row gap-2 mb-2">
                <?php
                $ing_nom = [
                    'name'        => 'ingredients[0][nom]',
                    'type'        => 'hidden',
                    'id'          => 'ing-nom-0'
                ];
                $ing_qte = [
                    'name'        => 'ingredients[0][quantite]',
                    'type'        => 'hidden',
                    'id'          => 'ing-qte-0'
                ];
                $ing_unite = [
                    'name'        => 'ingredients[0][unite]',
                    'type'        => 'hidden',
                    'id'          => 'ing-unite-0'
                ];
                ?>

                <!-- Champ visible unique -->
                <input type="text"
                    class="form-control ingredient-input"
                    placeholder="Ex: 200g farine, 2 oeufs..."
                    data-index="0">

                <!-- Champs cachés qui stockent les 3 valeurs -->
                <?= form_input($ing_nom) ?>
                <?= form_input($ing_qte) ?>
                <?= form_input($ing_unite) ?>

                <!-- Aperçu du parsing -->
                <small class="text-muted parsing-preview w-100"></small>

                <?= form_dropdown('ingredients[0][categorie]', $options_ingredients, '', ['class' => 'form-select w-25']) ?>
                <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mt-2 mb-3" id="ajouter-ingredient">+ Ajouter un ingrédient</button><br>
    </div>

    <div class="editeur">
        <label for="contenu">
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
        <input type="hidden" name="contenu" id="contenu" value="<?= set_value('contenu') ?>">

        <button type="submit" class="btn btn-primary">Envoyer</button>
        <?= form_close() ?>
    </div>
</div>
<?= $this->section('custom-js') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    const quill = new Quill('#editor', {
        modules: { //relie la toolbar qui est en dehors du form
            toolbar: '#toolbar'
        },
        placeholder: 'Écrivez votre recette ici...',
        theme: 'snow',
    });
    const existingContent = document.getElementById('contenu').value;
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
    const categoriesIngredient = <?= json_encode($options_ingredients) ?>;
    let index = 1;
    //ci dessous:
    document.getElementById('ajouter-ingredient').addEventListener('click', () => {
                const container = document.getElementById('ingredients-container');

                //ajouter une ligne
                const row = document.createElement('div');
                row.classList.add('ingredient-row', 'gap-2', 'mb-2');

                const options = Object.entries(categoriesIngredient)
                    .map(([val, label]) => `<option value="${val}">${label}</option>`)
                    .join('');

                row.innerHTML = `
    <input type="text"
        class="form-control ingredient-input"
        placeholder="Ex: 200g farine"
        data-index="${index}">

    <input type="hidden" name="ingredients[${index}][nom]" id="ing-nom-${index}">
    <input type="hidden" name="ingredients[${index}][quantite]" id="ing-qte-${index}">
    <input type="hidden" name="ingredients[${index}][unite]" id="ing-unite-${index}">

    <small class="text-muted parsing-preview w-100"></small>

    <select name="ingredients[${index}][categorie]" class="form-select w-25">
        ${options}
    </select>

    <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
`;
                
        container.appendChild(row);
        index++;
    });

    document.getElementById('ingredients-container').addEventListener('click', (e) => {
        if (e.target.classList.contains('supprimer-ligne')) {
            const rows = document.querySelectorAll('.ingredient-row');
            if (rows.length > 1) {
                e.target.closest('.ingredient-row').remove();
            } else {
                alert('Il faut au moins un ingrédient !');
            }
        }
    });

    // Gestion de la soumission du formulaire
    document.getElementById('form').addEventListener('submit', (e) => {
        const html = quill.root.innerHTML;
        document.getElementById('contenu').value = html;

        // Vérifier que ce n'est pas vide
        const text = quill.getText().trim();
        if (text.length === 0) {
            e.preventDefault(); //empêche l'envoi par défaut
            alert('Veuillez écrire une recette avant d\'envoyer');
        }
    });
</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>