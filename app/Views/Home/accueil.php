<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/accueil.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container">
    <h1>TEST</h1>
    <div class="box">
        <div class="recherche">
            <h2 class="rech">Rechercher une recette</h2>
        </div>
        <div class="connexion">
            <button class="btn btn-primary">Déjà membre</button>
            <button class="btn btn-primary">S'inscrire</button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>