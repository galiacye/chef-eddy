<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
    <title>Profil</title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Glass+Antiqua&family=Rubik+80s+Fade&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
<link href="<?=  base_url('/css/user/profile.css')?>" rel="stylesheet">
<?= $this->endSection() ?>
    
<?= $this->section('body') ?>
<div class="py-4 py-md-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card shadow-sm">

                <!-- En-tête -->
                <div class="card-header-dark">
                    <a href="<?= site_url('/') ?>" class="back-link">Accueil</a>
                    <h1>Profil de<br><span><?= esc($user->username) ?></span></h1>
                    <div class="avatar-wrap">
                        <div class="avatar">
                            <?php if (! empty($user->avatar)) : ?>
                                <img src="<?= esc($user->avatar) ?>" alt="Avatar">
                            <?php else : ?>
                                <?= strtoupper(mb_substr($user->username, 0, 1)) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Corps -->
                <div class="card-body pt-5 px-3 px-md-4">

                    <?php if ($isOwnProfile) : ?>
                        <span class="own-badge mb-3 d-inline-block">Votre profil</span>
                    <?php endif; ?>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6">
                            <div class="info-item">
                                <div class="info-label">Nom d'utilisateur</div>
                                <div class="info-value"><?= esc($user->username) ?></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="info-item">
                                <div class="info-label">Rôle</div>
                                <div class="info-value"><?= esc(ucfirst($user->role_id) ?? 'Membre') ?></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-item">
                                <div class="info-label">Adresse e-mail</div>
                                <div class="info-value"><?= esc($user->email) ?></div>
                            </div>
                        </div>
                        <?php if (! empty($user->bio)) : ?>
                        <div class="col-12">
                            <div class="info-item">
                                <div class="info-label">Bio</div>
                                <div class="info-value"><?= nl2br(esc($user->bio)) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($isOwnProfile) : ?>
                        <a href="<?= site_url('user/edit') ?>" class="btn-edit">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Modifier mon profil
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Pied -->
                <div class="card-foot d-flex flex-column flex-sm-row justify-content-between px-3 px-md-4 py-3 mt-3">
                    <span>Membre depuis le <?= date('d/m/Y', strtotime($user->created_at)) ?></span>
                    <?php if (! empty($user->updated_at)) : ?>
                        <span>Mis à jour le <?= date('d/m/Y', strtotime($user->updated_at)) ?></span>
                    <?php endif; ?>
<?= $this->endSection()?>