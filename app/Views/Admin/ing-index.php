<?php

/** @var object[] $ingredients */
?>

<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Tous les ingredients<?= $this->endSection() ?>
<?= $this->section('customcss') ?>
<?= $this->endSection() ?>
<?= $this->section('body') ?>


<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif ?>

<h2 class="text-center mb-4">Tous les ingredients</h2>

<div class="row">

    <?php foreach ($ingredients as $ing): ?>

        <div class="col-12 col-md-6 col-lg-4 mb-3">
            <p class="ing-nom"><?= esc($ing->name) ?></p>
<!--form anciennement a href pas secure-->
            <form method="post" action="<?= base_url('Admin/ingredients/delete/' . $ing->id) ?>">
                <?= csrf_field() ?>
                <button class="btn btn-warning mt-0 mb-4"
                    onclick="return confirm('Supprimer définitivement ?')">
                    Supprimer
                </button>
            </form>
        </div>

    <?php endforeach; ?>

</div>
<?= $this->endSection(); ?>