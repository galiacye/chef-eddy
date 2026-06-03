<?= $this->extend('layout') ?>
<?= $this->section('title') ?>
<h1 class="text-center mt-4">Mon compte</h1>
<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="/assets/css/profile.css" rel="stylesheet">
<?= $this->endSection() ?>
<?= $this->section('body') ?>

<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <nav class="navbar mb-3">
                <a href="<?= site_url('/') ?>">Accueil</a>
            </nav>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="fs-5 fw-500 mb-1">Mes informations</h1>
                    <p class="text-muted mb-0">Vos informations personnelles et de connexion.</p>
                </div>
                <a href="<?= site_url('User/editProfile') ?>" class="btn btn-save btn-sm">Modifier</a>
            </div>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success py-2 px-3 mb-3">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <div class="card border mb-3" style="border-radius:6px;">
                <div class="section-head">Informations personnelles</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <p class="text-muted small mb-1">Prénom</p>
                            <p class="mb-0 fw-500"><?= esc($user->firstname ?? '') ?: '&mdash;'?></p>
                        </div>
                        <div class="col-12 col-sm-6">
                            <p class="text-muted small mb-1">Nom</p>
                            <p class="mb-0 fw-500"><?= esc($user->lastname ?? '')  ?: '&mdash;' ?></p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted small mb-1">Téléphone</p>
                            <p class="mb-0"><?= esc($user->phone ?? '') ?: '&mdash;' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border mb-5" style="border-radius:6px;">
                <div class="section-head">Connexion</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <p class="text-muted small mb-1">Adresse e-mail</p>
                            <p class="mb-0"><?= esc($user->email ?? '') ?: '&mdash;' ?></p>
                        </div>
                        <div class="col-12">
<?= $this->endSection() ?>