<?= $this->extend('layout') ?>
<?= $this->section('body') ?>

<h2 class="text-center"><?= esc($tag->nom) ?></h2>

<div class="container">
    <div class="row">
        <?php foreach ($recipes as $recipe) : ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <img src="<?= base_url($recipe->image_url ? $recipe->image_url : 'uploads/default.jpg') ?>"
                         class="card-img-top"
                         alt="<?= esc($recipe->titre) ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= esc($recipe->titre) ?></h5>
                        <a href="<?= site_url('recette/' . $recipe->id) ?>" 
                           class="btn btn-primary mt-auto">Voir la recette</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>