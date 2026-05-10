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
<link href="<?= base_url('/css/user/profile.css') ?>" rel="stylesheet">
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
                                <?php if (! empty($user->avatar_url)) : ?>
                                    <img src="<?= base_url($user->avatar_url) ?>" alt="Avatar">
                                <?php else : ?>
                                    <?= strtoupper(mb_substr($user->username, 0, 1)) ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-5 px-3 px-md-4">
                        <?php if ($isOwnProfile): ?>
                            <span class="own-badge mb-3 d-inline-block">Votre profil</span>
                            <a href="<?= base_url('update-user/' . $user->id) ?>" class="btn btn-success mb-3">Modifier mon profil</a>
                        <?php endif ?>
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
                            <?php if (!empty($user->bio)): ?>
                                <div class="col-12">
                                    <div class="info-item">
                                        <div class="info-label">Bio</div>
                                        <div class="info-value"><?= nl2br(esc($user->bio)) ?></div>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- Pied -->
                    <div class="card-foot d-flex flex-column flex-sm-row justify-content-between px-3 px-md-4 py-3 mt-3">
                        <span>Membre depuis le <?= date('d/m/Y', strtotime($user->created_at)) ?></span>
                        <?php if (!empty($user->updated_at)): ?>
                            <span>Mis à jour le <?= date('d/m/Y', strtotime($user->updated_at)) ?></span>
                        <?php endif ?>
                    </div>
                </div> 
            </div> 
        </div> 
    </div> 
</div> 

<?= $this->endSection() ?>