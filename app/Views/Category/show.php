<?= $this->extend('layout') ?>

<?= $this->section('title') ?><title>category-show</title><?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/tags/tag-show.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<h2 class="text-center mt-5"><?= esc($category->name) ?></h2>

<div class="container">
    <div class="row mt-4">
        <?php foreach ($recipes as $recipe) : ?>
            <div class="col-12 col-md-4 col-lg-3 mb-4">
                <div class="recipe-card h-100 shadow">
                    <img src="<?= base_url($recipe->image_url ? $recipe->image_url : 'img/logo.png') ?>"
                         class="card-img-top"
                         alt="<?= esc($recipe->title) ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= esc($recipe->title) ?></h5><!--on ne précise pas en param où esc doit s'appliquer, par défaut sur balise html
                        on précise 'attr' si la var est entre guillemets d'une balise, si elle est son attribut, comme ds alt-->
                        <a href="<?= base_url('recipe/' . $recipe->id) ?>" 
                           class="btn btn-blue mt-auto">Voir la recette</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>