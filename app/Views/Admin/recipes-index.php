<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Recettes<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
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
</style>
<?= $this->endSection() ?>
<?= $this->section('body') ?>
<div class="container-fluid m-3">
    <div class="btn-group">
        <a href="<?= base_url('Admin/recipes-index/by-user') ?>">Par utilisateur</a>
        <a href="<?= base_url('Admin/recipes-index?statut=En attente') ?>"
            class="btn <?= $statut === 'En attente' ? 'btn-warning' : 'btn-outline-warning' ?>">En attente</a>
        <a href="<?= base_url('Admin/recipes-index?statut=Approuvée') ?>"
            class="btn <?= $statut === 'Approuvée' ? 'btn-success' : 'btn-outline-success' ?>">Approuvées</a>
        <a href="<?= base_url('Admin/recipes-index?statut=Rejetée') ?>"
            class="btn <?= $statut === 'Rejetée' ? 'btn-danger' : 'btn-outline-danger' ?>">Rejetées</a>
    </div>
    <div class="row m-3">
        <ul class="grenade-list">

            <?php foreach ($recipes as $recipe): ?>
                <li>
                    <div class="col m-3">

                        <h4 class="text-light"><span class="text-light"><?= $recipe->titre ?></span></h4>

                        <h4 class="text-light"><span class="text-info"><?= $recipe->username ?></span></h4>

                        <i class="fa-solid fa-bomb grenade-icon" onclick="alert('Grenade 1 cliquée !')">voir, modifier, supprimer ici</i>
                        <a href="<?= base_url('Admin/recipe-details/' . $recipe->id) ?>" class="btn btn-primary">Gérer</a>

                    </div>
                </li>
            <?php endforeach ?>
        </ul>
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