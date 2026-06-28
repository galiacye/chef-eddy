<?php

/**
 * @var \App\Entities\Recipe $recipe
 * @var array $tags
 * @var array $ingredients
 * @var int $recipe_id
 */
?>

<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= base_url('css/comments/add-comment.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<h4 class="mt-4 text-center">Ajoutez un commentaire</h4>
<form id="form" method="post" action="<?= base_url('comment/save') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="recipe_id" value="<?= (int)$recipe_id ?>">
    <!-- (int) caste la valeur en entier : si quelqu'un injecte du JS ou du HTML
     dans l'URL, le cast retourne 0 au lieu d'exécuter le code  
     nota bene : cast : forcer la valeur à prendre forme qu'on veut: garantie que la var est ce que doit-->
    <div class="editor-wrapper">
        <div id="toolbar">
            <span class="ql-formats">
                <button class="ql-bold"></button>
                <button class="ql-italic"></button>
                <button class="ql-underline"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-list" value="ordered"></button>
                <button class="ql-list" value="bullet"></button>
            </span>
            <span class="ql-formats">
                <button class="ql-link"></button>
            </span>
        </div>
        <div id="editor" class="shadow"></div>
        <textarea name="content" id="content" hidden></textarea>

        <div class="rating-container mt-3">
            <input type="hidden" name="rating" id="rating">
            <h5 class="mt-4">Donnez une note à la recette</h5>
            <div class="rating-stars">
                <i class="bi bi-star star" data-rating="1"></i>
                <i class="bi bi-star star" data-rating="2"></i>
                <i class="bi bi-star star" data-rating="3"></i>
                <i class="bi bi-star star" data-rating="4"></i>
                <i class="bi bi-star star" data-rating="5"></i>
            </div>
            <p>Votre note : <span id="selected-rating">0</span>/5</p>
        </div>
    </div>
    <input type="submit" value="envoyer" class="btn btn-blue mt-2 shadow">
</form>
<?= $this->endSection() ?>

<?= $this->section('customJs') ?>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="<?= base_url('/js/quill-comment.js') ?>"></script>
<?= $this->endSection() ?>