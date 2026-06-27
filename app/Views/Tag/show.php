<?= $this->extend('layout') ?>
<?= $this->section('title') ?>
<title>Recettes : <?= esc($tag->name) ?></title>
<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="<?= base_url('./css/tags/tag-show.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<h2 class="text-center m-4"><?= esc($tag->name) ?></h2>
<div class="container">
    <div class="row">

<?php foreach ($recipes as $recipe) : ?>
    <div class="col-12 col-md-4 col-lg-3 mb-4">
        <div class="recipe-card">

            <h5 class="recipe-title">
                <?= esc($recipe->title) ?>
            </h5>

            <img src="<?= base_url($recipe->image_url ?: 'uploads/default.jpg') ?>"
                 class="recipe-img"
                 alt="<?= esc($recipe->title) ?>">

            <a href="<?= site_url('recipe/' . $recipe->id) ?>"
               class="btn btn-blue w-100">
                Voir la recette
            </a>

        </div>
    </div>
<?php endforeach ?>
    </div>
</div>
<?= $this->endSection() ?>