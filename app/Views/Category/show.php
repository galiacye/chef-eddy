<?= $this->extend('layout') ?>
<?= $this->section('body') ?>

<h2 class="text-center"><?= esc($category->name) ?></h2>

<div class="container">
    <div class="row">
        <?php foreach ($recipes as $recipe) : ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <img src="<?= base_url($recipe->image_url ? $recipe->image_url : 'img/logo.png') ?>"
                         class="card-img-top"
                         alt="<?= esc($recipe->title) ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= esc($recipe->title) ?></h5>
                        <a href="<?= base_url('recipe/' . $recipe->id) ?>" 
                           class="btn btn-primary mt-auto">Voir la recette</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>