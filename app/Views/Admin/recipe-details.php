<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Recettes<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .recipe-img {
        height: 150px;
        width: 170px;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('body') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col d-flex justify-content-between">
            <h4 class="text-center">
                <?php /*foreach ($tags as $tag): ?>
                    <?= $tag->nom_tag ?>
                <?php endforeach */ ?>
            </h4>
            <h3 class="text-center"><?= $recipe->titre ?></h3>
            <img src="<?= $recipe->image_url ? base_url($recipe->image_url) : base_url('img/logo.png') ?>" class="recipe-img" alt="image recette">
        </div>
    </div>
    <div class="row">
        <table class="table table-dark">
            <tr>
                <th>Titre</th>
                <td><?= $recipe->titre ?></td>
            </tr>
            <tr>
                <th>Statut</th>
                <td><?= $recipe->statut ?></td>
            </tr>
            <tr>
                <th>Difficulté</th>
                <td><?= $recipe->difficulte ?></td>
            </tr>
            <tr>
                <th>Temps préparation</th>
                <td><?= $recipe->temps_preparation ?> min</td>
            </tr>
            <tr>
                <th>Temps cuisson</th>
                <td><?= $recipe->temps_cuisson ?> min</td>
            </tr>
            <tr>
                <th>Personnes</th>
                <td><?= $recipe->nb_personnes ?></td>
            </tr>
        </table>

        <h4>Ingrédients</h4>
        <ul>
            <?php foreach ($ingredients as $ingredient): ?>
                <li><?= $ingredient->nom ?> : <?= $ingredient->quantite ?> <?= $ingredient->unite ?></li>
            <?php endforeach ?>
        </ul>

        <div><?= $recipe->contenu ?></div>
    </div>
    <?= $this->endSection() ?>