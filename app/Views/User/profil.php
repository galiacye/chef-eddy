<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background: #f5f2ee; font-family: 'DM Sans', sans-serif; }
        .card { border: 1px solid #ddd8d0; border-radius: 12px; overflow: hidden; }
        .card-header-dark { background: #0f0e0d; padding: 2rem 2rem 3.5rem; position: relative; }
        .card-header-dark h1 { font-family: 'Playfair Display', serif; color: #fff; font-size: 1.7rem; margin-top: .8rem; }
        .card-header-dark h1 span { color: #c8a96e; }
        .back-link { color: #c8a96e; font-size: .75rem; text-transform: uppercase; letter-spacing: .07em; text-decoration: none; }
        .avatar-wrap { position: absolute; bottom: -2rem; left: 2rem; }
        .avatar { width: 70px; height: 70px; border-radius: 50%; border: 3px solid #fff; background: #f0e6d3; display: flex; align-items: center; justify-content: center; font-family: 'Playfair Display', serif; font-size: 1.8rem; color: #c8a96e; font-weight: 700; overflow: hidden; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        .own-badge { background: #f0e6d3; color: #c8a96e; font-size: .7rem; font-weight: 500; letter-spacing: .07em; text-transform: uppercase; padding: .2rem .7rem; border-radius: 99px; border: 1px solid #c8a96e; }
        .info-item { background: #f5f2ee; border: 1px solid #ddd8d0; border-radius: 10px; padding: .9rem 1.1rem; transition: border-color .2s; }
        .info-item:hover { border-color: #c8a96e; }
        .info-label { font-size: .68rem; text-transform: uppercase; letter-spacing: .08em; color: #8a857e; font-weight: 500; margin-bottom: .2rem; }
        .info-value { font-size: .95rem; color: #0f0e0d; word-break: break-word; }
        .btn-edit { background: #0f0e0d; color: #fff; border: none; border-radius: 10px; font-size: .88rem; font-weight: 500; padding: .65rem 1.4rem; text-decoration: none; display: inline-flex; align-items: center; gap: .4rem; transition: background .2s; }
        .btn-edit:hover { background: #2a2825; color: #fff; }
        .card-foot { border-top: 1px solid #ddd8d0; font-size: .75rem; color: #8a857e; }
    </style>
</head>
<body class="py-4 py-md-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card shadow-sm">

                <!-- En-tête -->
                <div class="card-header-dark">
                    <a href="<?= site_url('/') ?>" class="back-link">← Accueil</a>
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