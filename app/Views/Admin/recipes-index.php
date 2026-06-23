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
        <?= esc($success) ?>
    </div>
<?php endif ?>

<div class="container-fluid m-3">
    <div class="btn-group">

        <a href="<?= base_url('Admin/recipes-index?status=pending') ?>"
            class="btn <?= $status === 'pending' ? 'btn-warning' : 'btn-outline-warning' ?>">En attente</a>
        <a href="<?= base_url('Admin/recipes-index?status=approved') ?>"
            class="btn <?= $status === 'approved' ? 'btn-emeraude' : 'btn-outline-success' ?>">Approuvées</a>
  
    </div>
    <div class="row m-3">




        <ul class="grenade-list">

            <?php foreach ($recipes as $recipe): ?>
                <li>
                    <div class="recipe-info">
                        <h4><?= esc($recipe->title) ?></h4>
                        <p class="recipe-author"><?= esc($recipe->username) ?></p>
                    </div>
                    <div class="recipe-actions">
                        <a href="<?= base_url('Admin/recipe-details/' . $recipe->id) ?>" class="btn btn-blue">Voir</a>
                        <form action="<?= base_url('delete-recipe/' . $recipe->id) ?>" method="post"
                            onsubmit="return confirm('Supprimer définitivement cette recette?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-coralPlus">Supprimer</button>
                        </form>
                    </div>
                </li>

            <?php endforeach ?>
        </ul>
    </div>
</div>
<?php /*pour Admin:: ancienne methode recipesIndex sans la jointure :
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