<?= $this->extend('layout') ?>
<?= $this->section('custom-css') ?>
<link href="<?= base_url('./css/cat-index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>
<?= $this->section('body') ?>
<h2 class="text-center">Les catégories</h2>
<div class="container">
    <div class="row">
        <?php foreach ($categories as $categorie) : ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= base_url('img/logo.png') ?>" class="card-img-top" alt="<?= $categorie->nom ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $categorie->nom ?></h5>
                        <a href="<?= base_url('Categorie/' . $categorie->id) ?>" class="btn btn-primary mt-auto">Voir les recettes</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>
