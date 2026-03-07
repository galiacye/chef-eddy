<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<?= $this->endSection() ?>

<?= $this->section('body') ?>

<h1 class="text-center">Proposez une recette</h1>
<div id="toolbar">
  <button class="ql-bold"></button>
  <button class="ql-italic"></button>
  <button class="ql-underline"></button>
  <button class="ql-list" value="ordered"></button>
  <button class="ql-list" value="bullet"></button>
</div>

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
$content = [
    'name' => 'contenu',
    'id' => 'contenu',
    'value' => set_value('contenu'),
    'class' => 'form-control w-50'
];
$nb_pers = [
    'name' => 'nb_personnes',
    'id' => 'nb_personnes',
    'value' => set_value('nb_personnes'),
    'class' => 'form-control w-50'
];
$diff = [
    'name' => 'difficulte',
    'id' => 'difficulte',
    'value' => set_value('difficulte'),
    'class' => 'form-control w-50'
];
$status = [
    'name' => 'statut',
    'id' => 'statut',
    'value' => set_value('statut'),
    'class' => 'form-control w-50'
];
$views = [
    'name' => 'nb_vues',
    'id' => 'nb_vues',
    'value' => set_value('nb_vues'),
    'class' => 'form-control w-50'
];

?>
<?= form_open_multipart('add-recipe',['id' => 'form'])?>



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
<?= form_input($diff) ?>
<?= validation_show_error('difficulte') ?>


<label for="contenu">La Recette</label>
    <div id="editor" style="height: 300px; border: 1px solid #ccc;"></div>
<input type="hidden" name="contenu" id="contenu">


 <button type="submit" class="btn btn-primary">Envoyer</button>
<?= form_close() ?>

<?= $this->section('custom-js') ?>
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
     const quill = new Quill('#editor', {
    modules: {
        toolbar: '#toolbar'
    },
    placeholder: 'Écrivez votre commentaire ici...',
    theme: 'snow',
});

// Ajouter les tooltips en français
document.querySelector('.ql-bold').setAttribute('title', 'Gras');
document.querySelector('.ql-italic').setAttribute('title', 'Italique');
document.querySelector('.ql-underline').setAttribute('title', 'Souligné');
document.querySelector('.ql-list[value="ordered"]').setAttribute('title', 'Liste numérotée');
document.querySelector('.ql-list[value="bullet"]').setAttribute('title', 'Liste à puces');

// Gestion de la soumission du formulaire
document.getElementById('form').addEventListener('submit', (e) => {
    const html = quill.root.innerHTML;
    document.getElementById('contenu').value = html;
    
    // Vérifier que ce n'est pas vide
    const text = quill.getText().trim();
    if (text.length === 0) {
        e.preventDefault();//empêche l'envoi par défaut
        alert('Veuillez écrire un commentaire avant d\'envoyer');
    }
});
</script>
    
<?= $this->endSection() ?>

<?= $this->endSection() ?>