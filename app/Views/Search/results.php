<?= $this->extend('layout') ?>
<?= $this->section('body') ?>

<h2>Résultats de votre recherche</h2>
<?php if(empty($recipes)): ?>
    <p>Aucune recette trouvée</p>
<?php else: ?>
    <div class="row">
        <?php foreach($recipes as $recipe): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= base_url($recipe->image_url ?? 'img/default.jpg') ?>" class="card-img-top">
                        <div class="card-body">
                        <h5 class="card-title"><?= $recipe->titre ?></h5>
                        <p>Difficulté : <?= $recipe->difficulte ?></p>
                        <p>Temps de préparation : <?= $recipe->temps_preparation ?></p>
                        <p>Temps de cuisson : <?= $recipe->temps_cuisson ?></p>
                        <p>Nombre de personnes : <?= $recipe->nb_personnes ?></p>
                        <a href="<?= base_url('recipe/'. $recipe->id) ?>" class="btn btn-primary">Voir la recette</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php endif ?>
<?= $this->endSection()?>
