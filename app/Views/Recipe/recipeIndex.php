<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="allRecipes.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<?php foreach($recipes as $recipe): ?>
    <div class="intro">            
        <h1><?= esc($recipe->titre) ?></h1>

        <?php if ($recipe->image_url): ?>
            <img src="<?= base_url($recipe->image_url) ?>" alt="image recette" class="img">
        <?php else: ?>
            <img src="<?= base_url('images/default-recipe.png') ?>" alt="image par défaut" class="img">
        <?php endif ?>
    </div>
<?php endforeach ?>
<?= $this->endSection()?>


