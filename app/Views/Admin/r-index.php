
<!--*******ch---->

<div class="recipe-table">

    <div class="recipe-row recipe-header">
        <div>Recette</div>
        <div>Auteur</div>
        <div class="text-end">Actions</div>
    </div>

    <?php foreach ($recipes as $recipe) : ?>

        <div class="recipe-row">

            <!-- recette -->
            <div class="recipe-main">
                <strong><?= esc($recipe->title) ?></strong>
            </div>

            <!-- auteur -->
            <div class="recipe-author">
                <?= esc($recipe->author ?? '—') ?>
            </div>

            <!-- actions -->
            <div class="recipe-actions">
                <a href="#" class="btn btn-sm btn-primary">Voir</a>
                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                <a href="<?= base_url('Admin/recipe/remove/' . $recipe->id) ?>" class="btn btn-sm btn-danger">Suppr</a>
            </div>

        </div>

    <?php endforeach ?>

</div>

<!----********chfin-->