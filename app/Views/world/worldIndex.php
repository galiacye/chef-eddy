<?= $this->extend('layout') ?>
<?= $this->section('meta_description') ?>Recettes de cuisine <?= esc($COUNTRY) ?>Saveurs du monde sur Chef Eddy<?= $this->endSection() ?>
<?= $this->section('title') ?>
<title>Cuisine du monde</title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/recipes/recipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container">

    <h1>Cuisine du monde</h1>

     <!-- Liste des pays retournés par l'API, affichés comme des tags cliquables  -->
    <div class="tags">
        <?php foreach ($countries as $country): ?>
            <a href="<?= site_url('cuisine-du-monde/' . urlencode($country['strArea'])) ?>" class="tag">
                <?= esc($country['strArea']) ?>
            </a>
        <?php endforeach ?>
    </div>

</div>
<?= $this->endSection() ?>