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
<link href="<?= base_url('assets/css/add-comment.css') ?>" rel="stylesheet">
<style>
    #editor {
        background-color: white;
        height: 200px;
        margin-left: 2rem;
        margin-right: 2rem;

    }

    #toolbar {
        background-color: white;
        margin-left: 2rem;
        margin-right: 2rem;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<h2>Ajoutez un commentaire</h2>

<form id="form" method="post" action="<?= base_url('comment/save') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="recipe_id" value="<?= $recipe_id ?>">
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
    <div id="editor"></div>
    <textarea name="content" id="content" hidden></textarea>

    <input type="hidden" name="rating" id="rating">
    <input type="submit" value="envoyer" class="btn btn-primary">
</form>
<h2>Donnez-nous une note</h2>
<div class="rating-stars">
    <i class="bi bi-star star" data-rating="1"></i>
    <i class="bi bi-star star" data-rating="2"></i>
    <i class="bi bi-star star" data-rating="3"></i>
    <i class="bi bi-star star" data-rating="4"></i>
    <i class="bi bi-star star" data-rating="5"></i>
</div>
<p>Votre note : <span id="selected-rating">0</span>/5</p>

<?= $this->endSection() ?>

<?= $this->section('custom-js') ?>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="<?= base_url('/js/quill-comment.js') ?>"></script>
<?= $this->endSection() ?>