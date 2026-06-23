<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Recettes<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="<?= base_url('css/Admin/recipe-details.css') ?>" rel="stylesheet">
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
            <h3 class="text-center"><?= esc($recipe->title) ?></h3>
            <img src="<?= $recipe->image_url ? base_url($recipe->image_url) : base_url('img/logo.png') ?>" class="recipe-img" alt="image recette">
        </div>
    </div>
    <div class="row">
        <table class="table table-dark">
            <tr>
                <th>Titre</th>
                <td><?= esc($recipe->title) ?></td>
            </tr>
            <tr>
                <th>Statut</th>
                <td><?= esc($recipe->status) ?></td>
            </tr>
            <tr>
                <th>Difficulté</th>
                <td><?= esc($recipe->difficulty) ?></td>
            </tr>
            <tr>
                <th>Temps préparation</th>
                <td><?= esc($recipe->prep_time) ?> min</td>
            </tr>
            <tr>
                <th>Temps cuisson</th>
                <td><?= esc($recipe->cook_time) ?> min</td>
            </tr>
            <tr>
                <th>Personnes</th>
                <td><?= esc($recipe->portions) ?></td>
            </tr>
        </table>

        <h4>Ingrédients</h4>
        <ul>
            <?php foreach ($ingredients as $ingredient): ?>
                <li><?= esc($ingredient->name) ?> : <?= esc($ingredient->quantity) ?> <?= esc($ingredient->unit) ?></li>
            <?php endforeach ?>
        </ul>

        <div><?= esc($recipe->content) ?></div>
    </div>
    <div class="btn-box d-flex">

        <!---btn reject pas supp-->
        <?php
        if ($recipe->status === 'pending') { ?>
            <form action="<?= base_url('Admin/recipe/reject/' . $recipe->id) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-coralPlus">Rejeter</button>
            </form>

            <form action="<?= base_url('Admin/recipe/save/' . $recipe->id) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-emeraude">Approuver</button>
            </form>
<div class="btn-bottom">
            <form action="<?= base_url('Admin/recipe/pending/' . $recipe->id) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-secondary btn-sm">Remettre en attente</button>
            </form>
</div>

        <?php } elseif ($recipe->status === 'approved') { ?>
            <form action="<?= base_url('Admin/recipe/reject/' . $recipe->id) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-coralPlus">Rejeter</button>
            </form>

            <form action="<?= base_url('Admin/recipe/pending/' . $recipe->id) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-secondary btn-sm">Remettre en attente</button>
            </form>

        <?php } elseif ($recipe->status === 'rejected') { ?>
            <form action="<?= base_url('Admin/recipe/save/' . $recipe->id) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-blue">Approuver</button>
            </form>

            <form action="<?= base_url('Admin/recipe/pending/' . $recipe->id) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-secondary btn-sm">Remettre en attente</button>
            </form>
        <?php } ?>




    </div>
</div>
<?= $this->endSection() ?>