<?= $this->extend('layouAdmin') ?>
<?= $this->section('titre') ?>Tous les commentaires<?= $this->endSection() ?>
<?= $this->section('customcss') ?>

<?= $this->endSection() ?>
<?= $this->section('body') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif ?>

<h2 class="text-center mb-4">Tous les commentaires</h2>

<div class="row">

    <?php foreach ($comments as $c): ?>

        <div class="col-12 col-md-6 col-lg-4 mb-3">
    <!-- user_id est ds $c grâce au join du model-->
            <p class="username"><a href="<?= base_url('user/profile/') . $c->user_id ?>"><?= $c->username ?></a></p>
        <!--idem pour recipe_title-->
            <p class="recipe"><?= $c->recipe_title ?></p>
            <p class="com-content"><?= $c->content ?></p>

            <a class="btn btn-warning"
               onclick="return confirm('Supprimer définitivement ce commentaire ?')"
               href="<?= base_url('/delete-comment/' . $c->id) ?>">
                Supprimer le commentaire
            </a>
        </div>

    <?php endforeach; ?>

</div>
<?= $this->endSection(); ?>