<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Dashboard<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="dashboard.css" rel="stylesheet">
<style>
    body {
        background-image: url('<?= base_url('img/topo.png') ?>');
        background-size: cover;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('body') ?>

<h1 class="mb-4">Tableau de bord</h1>

<div class="row g-3 mb-5">
    <div class="col-md-4">
        <div class="card text-center p-3">
            <h2><?= $nb_users ?></h2>
            <p class="text-muted mb-0">Utilisateurs</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center p-3">
            <h2><?= $nb_recipes ?></h2>
            <p class="text-muted mb-0">Recettes</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center p-3 border-warning">
            <h2><?= $nb_recipes_pending ?></h2>
            <p class="text-muted mb-0">En attente</p>
        </div>
    </div>
</div>

<div class="row g-3">
      <div class="col-md-6">
        <a href="Admin/users-index" class="card p-3 text-decoration-none text-dark d-block">
            <h5>Utilisateurs</h5>
            <p class="text-muted mb-0">Comptes, rôles, accès</p>
        </a>
    </div>
    <div class="col-md-6">
        <a href="Admin/recipes-index" class="card p-3 text-decoration-none text-dark d-block">
            <!-- text-decoration-none pour ôter le style bleu du lien  <a> -->
            <h5>Recettes</h5>
            <p class="text-muted mb-0">Gérer, modifier, supprimer</p>
        </a>
    </div>
  
</div>

<?= $this->endSection() ?>
   





