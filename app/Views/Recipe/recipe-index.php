<?= $this->extend('layout') ?>
<?= $this->section('title') ?>
<title>Toutes les recettes</title>
<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/recipes/recipeIndex.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<h1 class="text-center mt-4">Toutes les recettes</h1>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-6 g-3 mt-2">
<!--row-cols deter nb de col ds la ligne . pratique-->
    <?php foreach ($recipes as $recipe): ?>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <?php if ($recipe->image_url): ?>
                    <img src="<?= base_url($recipe->image_url) ?>"
                        class="card-img-top recipe-img"
                        alt="image recette">
                <?php else: ?>
                    <img src="<?= base_url('images/default-recipe.png') ?>"
                        class="card-img-top recipe-img"
                        alt="image par défaut">
                <?php endif ?>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">
                        <?= esc($recipe->title) ?>
                    </h5>
                    <a href="<?= base_url('recipe/' . $recipe->id) ?>"
                        class="btn btn-recipe btn-sm mt-auto">
                        Voir la recette
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach ?>

</div>
<?= $this->endSection() ?>