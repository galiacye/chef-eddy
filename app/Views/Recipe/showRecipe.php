<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="./css/recipe.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<div class="ban">
        <h1><?= $recipe->titre . '<br>' ?></h1>
        <img src="<?= base_url($recipe->image_url) ?>" alt="image recette" style="width:300px;border:3px solid red;">
        <p><?= $recipe->difficulte ?></p>
</div>

<?= $this->endSection() ?>