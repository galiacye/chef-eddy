<?= $this->extend('layout') ?>
<?= $this->section('meta_description') ?>Saveurs du monde sur Chef Eddy<?= $this->endSection() ?>
<?= $this->section('title') ?>
<title>Cuisine du monde</title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/world/world-tag.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container">
    
        <h1 class="text-center mt-4 mb- title">Cuisine du monde</h1>
        <!-- liste des pays retournés par l'api, affichés comme des tags cliquables  -->
  
    <div class="row">
        <div class="btn-bloc d-flex gap-2 flex-wrap justify-content-between">
            <?php foreach ($countries as $country): ?>

                <a href="<?= site_url('cuisine-du-monde/' . urlencode($country['strArea'])) ?>" class="btn my-1 btn-worldTag">
                    <!--strArea: clé json du pays-->
                    <?= esc($country['strArea']) ?>
                </a>
            <?php endforeach ?>
        </div>
    </div>


</div>
<?= $this->endSection() ?>