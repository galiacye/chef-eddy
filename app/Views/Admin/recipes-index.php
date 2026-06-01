<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Recettes<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="<?= base_url('css/Admin/recipes-index.css') ?>" rel="stylesheet">
<!--<style>
    body {
        background-image: url('<?= base_url('img/topo.png') ?>');
        background-size: cover;
    }

    .grenade-list {
        list-style: none;
        padding-left: 0;
    }

    .grenade-list li {
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .grenade-icon {
        color: #ff8800;
        /* couleur grenat/orange */
        cursor: pointer;
        font-size: 1rem;
        transition: transform 0.2s;
    }

    .grenade-icon:hover {
        transform: scale(1.2);
        color: red;
    }
</style>-->
<?= $this->endSection() ?>
<?= $this->section('body') ?>

<?php $success = session()->getFlashdata('success') ?>
<?php if ($success) : ?>
    <div class="alert alert-success">
        <?= $success ?>
    </div>
<?php endif ?>

<div class="container-fluid m-3">
    <div class="btn-group">
       
        <a href="<?= base_url('Admin/recipes-index?status=En attente') ?>"
            class="btn <?= $status === 'En attente' ? 'btn-warning' : 'btn-outline-warning' ?>">En attente</a>
        <a href="<?= base_url('Admin/recipes-index?status=Approuvée') ?>"
            class="btn <?= $status === 'Approuvée' ? 'btn-success' : 'btn-outline-success' ?>">Approuvées</a>
        <a href="<?= base_url('Admin/recipes-index?status=Rejetée') ?>"
            class="btn <?= $status === 'Rejetée' ? 'btn-danger' : 'btn-outline-danger' ?>">Rejetées</a>
    </div>
    <div class="row m-3">


<!--*******ch---->

<div class="recipe-table">

    <div class="recipe-row recipe-header">
        <div>Recette</div>
        <div>Auteur</div>
        <div class="text-end">Actions</div>
    </div>

    <?php foreach ($recipes as $recipe) : ?>

        <div class="recipe-row">

            <!-- recette -->
            <div class="recipe-main">
                <strong><?= esc($recipe->title) ?></strong>
            </div>

            <!-- auteur -->
            <div class="recipe-author">
                <?= esc($recipe->author ?? '—') ?>
            </div>

            <!-- actions -->
            <div class="recipe-actions">
                <a href="#" class="btn btn-sm btn-primary">Voir</a>
                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Suppr</a>
            </div>

        </div>

    <?php endforeach ?>

</div>

<!----********chfin-->


        <!-- <ul class="grenade-list">

            <?php foreach ($recipes as $recipe): ?>
                <li>
                    <div class="recipe-info">
                        <h4><?= $recipe->title ?></h4>
                        <p class="recipe-author"><?= $recipe->username ?></p>
                    </div>
                    <div class="recipe-actions">
                        <a href="<?= base_url('Admin/recipe-details/' . $recipe->id) ?>" class="btn btn-primary">Voir</a>
                        <form action="<?= base_url('delete-recipe/' . $recipe->id) ?>" method="post"
                            onsubmit="return confirm('Supprimer définitivement cette recette?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                </li>

            <?php endforeach ?>
        </ul> -->
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
<?php endforeach */ ?>
<?= $this->endSection() ?>