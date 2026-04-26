<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>

<link href="<?= base_url('./css/recipes/createRecipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<h2 class="text-center">Modifier une de vos recettes</h2>

<?php
$title = [
    'name' => 'titre',
    'id' => 'titre',
    'value' => set_value('titre', isset($recipe->titre) ? $recipe->titre : ''),
    'class' => 'form-control w-50'
];
$image = [
    'name' => 'image_url',
    'id' => 'image_url',
    'value' => set_value('image_url', isset($recipe->image) ? $recipe->image_url : ''),
    'class' => 'form-control w-50'
];
$tp = [
    'name' => 'temps_preparation',
    'id' => 'temps_preparation',
    'value' => set_value('temps_preparation', isset($recipe->temps_preparation) ? $recipe->temps_preparation : ''),
    'class' => 'form-control w-50'
];
$tc = [
    'name' => 'temps_cuisson',
    'id' => 'temps_cuisson',
    'value' => set_value('temps_cuisson', isset($recipe->temps_cuisson) ? $recipe->temps_cuisson : ''),
    'class' => 'form-control w-50'
];

$nb_pers = [
    'name' => 'nb_personnes',
    'id' => 'nb_personnes',
    'value' => set_value('nb_personnes', isset($recipe->nb_personnes) ? $recipe->nb_personnes : ''),
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
    $options_categories[$categorie->id] = $categorie->nom; //valeur envoyée en base(id)  = ce que user voit(nom renvoyé par la base pour id)
}
?>
<?= form_open_multipart('update-recipe/' . $recipe->id, ['id' => 'form']) ?>
<div class="formulaire">
    <!-- $status et $views gérées ds ctrlr -->
    <div class="infos">

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
        <?= form_dropdown('difficulte', $diff_options, 
            set_value('difficulte', isset($recipe->difficulte) ? $recipe->difficulte : ''), //set_value vient en 3ème argument
            ['id' => 'difficulte', 'class' => 'form-select w-50']) ?>
        <?= validation_show_error('difficulte') ?>

        <label for="categorie_id">Catégorie</label>
        <?= form_dropdown('categorie_id', $options_categories, 
            set_value('categorie_id', isset($recipe->categorie_id) ? $recipe->categorie_id : ''), $cat) ?>
        <?= validation_show_error('categorie_id') ?>

        <label>Ingrédients</label>
            <!--ici pas de champs unique, posssibilité de retoucher grammage uniquement, par ex-->         
    <div id="ingredients-container">
    <?php foreach ($ingredients as $index => $ing) : ?>
    <div class="ingredients-row gap-2 mb-2">
        <input type="text"   name="ingredients[<?= $index ?>][nom]"      value="<?= esc($ing->nom) ?>"      placeholder="Nom"            class="form-control">
        <input type="number" name="ingredients[<?= $index ?>][quantite]" value="<?= esc($ing->quantite) ?>" placeholder="Quantité"       class="form-control w-25">
        <input type="text"   name="ingredients[<?= $index ?>][unite]"    value="<?= esc($ing->unite) ?>"    placeholder="Unité (g, ml…)" class="form-control w-25">
        <!--form_dropdown gère champs simples, pas les noms indexés dynamiquement comme ingredient[index][categorie].-->
        <select name="ingredients[<?= $index ?>][categorie]" class="form-select w-25">
            <?php foreach($options_ingredients as $key=>$name): ?>
                <option value = "<?= $key ?>" 
                    <?= set_select("ingredients[{$index}][categorie]", //set_select() comme set_value relit $POST cas echec validation et le réaffiche (flash conservé par CI4)
                     $key, isset($ing->categorie)) && $ing->categorie = $key ?>>
                <?= $name ?>
                </option>
            <?php endforeach; ?>

        </select>
        <button type="button" class="btn btn-danger supprimer-ligne">✕</button>
    </div>
    <?php endforeach; ?>
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
        <input type="hidden" name="contenu" id="contenu" value="<?= set_value('contenu', $recipe->contenu ?? '') ?>">
        <!-- $recipe->contenu pr que l'ancien contenu s'affiche -->
        <button type="submit" class="btn btn-primary">Envoyer</button>
        
    </div>
</div>
<?= form_close() ?>
<form action="<?= base_url('/delete-recipe/' . $recipe->id)?>" method="post">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Supprimer définitivement cette recette?')">Supprimer</button>
        </form>
            
<?= $this->section('custom-js') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    const categoriesIngredients = <?= json_encode($options_ingredients) ?>;
    let index = <?= !empty($ingredients)? count($ingredients) : 1 ?>
</script>
<script>document.addEventListener('DOMContentLoaded', () => {
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

    document.getElementById('ajouter-ingredient').addEventListener('click', () => {
        const container = document.getElementById('ingredients-container');
        const row = document.createElement('div');
        row.classList.add('ingredients-row', 'gap-2', 'mb-2');

        const options = Object.entries(categoriesIngredient)
            .map(([val, label]) => `<option value="${val}">${label}</option>`)
            .join('');

        row.innerHTML = `
        <input type="text"   name="ingredients[${index}][nom]"      placeholder="Nom"            class="form-control">
        <input type="number" name="ingredients[${index}][quantite]" placeholder="Quantité"       class="form-control w-25">
        <input type="text"   name="ingredients[${index}][unite]"    placeholder="Unité (g, ml…)" class="form-control w-25">
        <select name="ingredients[${index}][categorie]" class="form-select w-25">${options}</select>
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
        document.getElementById('contenu').value = html;

        // Vérifier que ce n'est pas vide
        const text = quill.getText().trim();
        if (text.length === 0) {
            e.preventDefault(); //empêche l'envoi par défaut
            alert('Veuillez remplir le formulaire avant d\'envoyer');
        }
    });
})</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>