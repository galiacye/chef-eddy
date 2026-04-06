<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Recettes<?= $this->endSection() ?>
<?= $this->section('body') ?>
   <div class="container-fluid m-3">
    <div class="row m-3">
        <?php foreach($recipes as $recipe):?>
            <div class="col m-3">
                <h4>Recette</h4>
                <?= $recipe->titre ?>
                <h4>Auteur</h4>
                <?= $recipe->username ?>
            </div>
        <?php endforeach ?>
    </div>
   </div>
   <?php /*pour Admin::recipesIndex sans la jointure :
   foreach($recipes as $recipe): ?>
    <div class="col m-3">
        <h4>Recette</h4>
        <?= $recipe->titre ?>
        <h4>Auteur</h4>
        <?php foreach($users as $user): ?>
            <?php if($user->id == $recipe->user_id): ?>
                <?= $user->username ?>
            <?php endif ?>
        <?php endforeach ?>
    </div>
<?php endforeach */?>
<?= $this->endSection() ?>