<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
<title>Service indisponible</title>
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container">
<!-- pas de connexion, timeout...)  -->
    <h1>Cuisine du monde indisponible</h1>
    <p>Cette section nécessite une connexion internet.</p>

    <a href="<?= site_url('/') ?>" class="btn-action">Retour à l'accueil</a>

</div>
<?= $this->endSection() ?>