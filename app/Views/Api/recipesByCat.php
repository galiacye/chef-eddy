<?= $this->extend('layout') ?>

<?= $this->section('customcss') ?>
<link href="<?= base_url('css/recipesByCat.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<h1>Les recettes par catégorie</h1>
<div class="row m-4">
<div class="col md-4 lg-3">
<?php foreach($resultat->categories as $categorie): ?>
    <h2><?= $categorie->strCategory ?></h2>
<?php endforeach; ?>
</div>
</div>
<?= $this->endSection() ?>