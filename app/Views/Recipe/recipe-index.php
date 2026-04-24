<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/recipes/recipeIndex.css')?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif ?>

<?php foreach($recipes as $recipe): ?>
    <div class="intro">            
        <?php if ($recipe->image_url): ?>
            <img src="<?= base_url($recipe->image_url) ?>" alt="image recette" class="recipe-img">
        <?php else: ?>
            <img src="<?= base_url('images/default-recipe.png') ?>" alt="image par défaut" class="img">
        <?php endif ?>
        <p><?= esc($recipe->titre) ?></p>
    </div><br>
<?php endforeach ?>
<?= $this->endSection()?>


