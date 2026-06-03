<?= $this->extend('layout') ?>
<?= $this->section('title') ?>
<title>Favorites</title>
<?= $this->endSection() ?>
<?= $this->section('body') ?>
<div class="container py-4">

    <h1 class="mb-4">Mes favoris</h1>

    <?php if (! empty($favorites)) : ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($favorites as $fav) : ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="<?= site_url('recipes/' . $fav['id']) ?>">
                                    <?= esc($fav['title']) ?><!--$fav est un tab car getByUser utilise getResultArray()-->
                                </a>
                            </h5>
                        </div>
                        <div class="card-footer">
                            <!-- bouton pour retirer directement depuis la liste -->
                            <form action="<?= site_url('favorites/toggle/' . $fav['id']) ?>" method="post">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Retirer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php else : ?>
        <p class="text-muted text-center">Vous n'avez pas encore de recette en favori.</p>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>