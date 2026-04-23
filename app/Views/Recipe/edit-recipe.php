<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="<?= base_url('css/quill.css') ?>" rel="stylesheet">
<link href="<?= base_url('./css/recipes/createRecipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<h2>Recette</h2>
<div id="quill-editor"></div>
<h2>Ingredients</h2>

<?php


$ing_nom = [
    'name' => 'ingredient[0][nom]', //envoie un tableau via php 'post':$_POST['ingredient'][0]['nom'] 
    //tableaux imbriqués:    php$_POST['ingredient']->tab ingredients
    //$_POST['ingredient'][0] -> le 1er ingrédient (index 0) 
    //$_POST['ingredient'][0]['nom']-> le nom de ce 1er ingrédient
    'type' => 'hidden',
    'id' => 'ing-nom-0'
];
$ing_qte = [
    'name' => 'ingredient[0][quantite]',
    'type' => 'hidden',
    'id' => 'ing-qte-0'
];
$ing_unite = [
    'name' => 'ingredient[0][unite]',
    'type' => 'hidden',
    'id' => 'ing-unite-0'
]; ?>
<!-- //le champ unique visible -->
<input type="text" class="form-control ingredient-input"
    placeholder="ex: 200g de farine"
    data-index="0"
    data-preview="preview-0"><!--chaque input connait son preview grâce à data-preview-->
<!--les 3 champs cachés-->
<?= form_input($ing_nom) ?>
<?= form_input($ing_qte) ?>
<?= form_input($ing_unite) ?>

<small id="preview-0" class="text-muted w-100 aperçu"></small>



<script>
    //pour partitionner ing, unité, quantité avec 3 champs invisibles et une regex
    const unite = <?= json_encode($unite) ?>; //traduis

    // Échappe les caractères spéciaux de la regex
    function escapeRegex(str) {
        return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function parseIngredient(texte) { //s'executera avec addEventListenr
        const unitesEchappees = unite.map(u => escapeRegex(u));
        const regex = new RegExp(
            `^(\\d+[.,]?\\d*)\\s*(${unitesEchappees.join('|')})?\\s*(.+)$`, 'i'
        );
        const match = texte.trim().match(regex); //match compare ce qu'user a tapé avec la regex
        //et retourne parties capturées
        if (match) {
            return {
                quantite: match[1],
                unite: match[2] || '', //unité optionnelle donc string vide si pas de match[2]
                nom: match[3].trim()
            };
        }

        // Si pas de match (ex: "sel", "poivre")
        return {
            quantite: '',
            unite: '',
            nom: texte.trim()
        };
    }

    document.querySelectorAll('.ingredient-input').foreach(input => {
        input.addEventListener("blur", () => { //blur = quand user quitte le champ appelle parseIng 
            //qui remplit les tab imbriqués ingredient[0][nom] , ingredient[0][quantite], ingredient[0][unite]
            const resultat = parseIngredient(input.value);
            const index = input.dataset.index;
        })
    })

    document.getElementById(`ing-nom-{$index}`).value = resultat.nom;
    document.getElementById(`ing-qte-{$index}`).value = resultat.quantite;
    document.getElementById(`ing-unite-{$index}`).value = resultat.unite;

    const preview = document.getElementById(input.dataset.preview);
    if (preview) {
        preview.textContent = `${resultat.quantite} ${resultat.unite} ${resultat.nom}`;
    }
</script>
<!-- regex -->
<!-- ^ : début du texte
(\\d+[.,]?\\d*) : capture un nombre (ex: 200, 1.5, 2,5)
\\s* : espace(s) optionnel(s)
(${unite.join('|')})? : capture une unité (kg|g|ml...) optionnelle (le ? = peut être absent)
\\s* : espace(s) optionnel(s)
(.+) : capture le reste = le nom
$ : fin du texte -->



//<!--createRecipe ajouter un ingredients anciennnes lignes-->
    row.innerHTML = `
        <input type="text"   name="ingredients[${index}][nom]"      placeholder="Nom"            class="form-control">
        <input type="number" name="ingredients[${index}][quantite]" placeholder="Quantité"       class="form-control w-25">
        <input type="text"   name="ingredients[${index}][unite]"    placeholder="Unité (g, ml…)" class="form-control w-25">
        <select name="ingredients[${index}][categorie]" class="form-select w-25">${options}</select>
        <button type="button" class="btn btn-danger supprimer-ligne">✕</button>