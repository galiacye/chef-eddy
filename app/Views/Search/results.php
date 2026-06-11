<?= $this->extend('layout') ?>
<?= $this->section('body') ?>

<h2>Résultats de votre recherche</h2>
<?php if(empty($recipes)): ?>
    <p>Aucune recette trouvée</p>
<?php else: ?>
    <div class="row">
        <?php foreach($recipes as $recipe): ?>
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card">
                    <img src="<?= base_url($recipe->image_url ?? 'img/default.jpg') ?>" class="card-img-top">
                        <div class="card-body">
                        <h5 class="card-title"><?= esc($recipe->title) ?></h5>
                        <p>Difficulté : <?= esc($recipe->difficulty) ?></p>
                        <p>Temps de préparation : <?= esc($recipe->prep_time) ?></p>
                        <p>Temps de cuisson : <?= esc($recipe->cook_time) ?></p>
                        <p>Nombre de personnes : <?= esc($recipe->portions) ?></p>
                        <a href="<?= base_url('recipe/'. (int)$recipe->id) ?>" class="btn btn-primary">Voir la recette</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
<?= $this->endSection()?>
