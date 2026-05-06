
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mes informations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background: #f8f8f6; font-family: 'Inter', sans-serif; }
        .section-head { font-size: .75rem; font-weight: 500; text-transform: uppercase; letter-spacing: .07em; color: #6b6b6b; border-bottom: 1px solid #e2e2e0; padding: .85rem 1.25rem; }
        .form-label { font-size: .8rem; font-weight: 500; color: #1a1a1a; }
        .form-control { font-size: .88rem; border-color: #e2e2e0; }
        .form-control:focus { border-color: #1a1a1a; box-shadow: none; }
        .form-text { font-size: .73rem; }
        .btn-save { background: #1a1a1a; color: #fff; font-size: .85rem; font-weight: 500; border: none; padding: .6rem 1.4rem; }
        .btn-save:hover { background: #333; color: #fff; }
        .danger-zone { border: 1px solid #f5c6c6; border-radius: 6px; }
        .btn-danger-soft { background: none; border: 1px solid #f5c6c6; color: #c0392b; font-size: .82rem; white-space: nowrap; }
        .btn-danger-soft:hover { background: #fdf0ef; color: #c0392b; border-color: #f5c6c6; }
        .breadcrumb-item a { color: #6b6b6b; text-decoration: none; font-size: .8rem; }
        .breadcrumb-item.active { font-size: .8rem; }
    </style>
</head>
<body class="py-4 py-md-5">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-7">

            <!-- Fil d'ariane -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('user/profile') ?>">Mon compte</a></li>
                    <li class="breadcrumb-item active">Modifier</li>
                </ol>
            </nav>

            <h1 class="fs-5 fw-500 mb-1">Mes informations</h1>
            <p class="text-muted mb-4" style="font-size:.82rem">Modifiez vos informations personnelles et de connexion.</p>

            <!-- Flash messages -->
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success py-2 px-3" style="font-size:.83rem">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger py-2 px-3" style="font-size:.83rem">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?= form_open('user/updateProfile') ?>

                <!-- Informations personnelles -->
                <div class="card border mb-3" style="border-color:#e2e2e0!important; border-radius:6px;">
                    <div class="section-head">Informations personnelles</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <label for="firstname" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" id="firstname" name="firstname" class="form-control <?= isset($errors['firstname']) ? 'is-invalid' : '' ?>"
                                       value="<?= old('firstname', esc($user->firstname ?? '')) ?>">
                                <?php if (isset($errors['firstname'])) : ?>
                                    <div class="invalid-feedback"><?= $errors['firstname'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="lastname" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" id="lastname" name="lastname" class="form-control <?= isset($errors['lastname']) ? 'is-invalid' : '' ?>"
                                       value="<?= old('lastname', esc($user->lastname ?? '')) ?>">
                                <?php if (isset($errors['lastname'])) : ?>
                                    <div class="invalid-feedback"><?= $errors['lastname'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="tel" id="phone" name="phone" class="form-control"
                                       value="<?= old('phone', esc($user->phone ?? '')) ?>">
                                <div class="form-text">Utilisé uniquement pour le suivi de commande.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Connexion -->
                <div class="card border mb-3" style="border-color:#e2e2e0!important; border-radius:6px;">
                    <div class="section-head">Connexion</div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="email" class="form-label">Adresse e-mail <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                                       value="<?= old('email', esc($user->email ?? '')) ?>">
                                <?php if (isset($errors['email'])) : ?>
                                    <div class="invalid-feedback"><?= $errors['email'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <label for="password" class="form-label">Nouveau mot de passe</label>
                                <input type="password" id="password" name="password"
                                       class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                                       placeholder="Laisser vide pour ne pas changer">
                                <?php if (isset($errors['password'])) : ?>
                                    <div class="invalid-feedback"><?= $errors['password'] ?></div>
                                <?php endif; ?>
                                <div class="form-text">8 caractères minimum, avec au moins un chiffre.</div>
                            </div>
                            <div class="col-12">
                                <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                                <input type="password" id="password_confirm" name="password_confirm"
                                       class="form-control" placeholder="Répétez le nouveau mot de passe">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex align-items-center justify-content-between mb-5">
                    <a href="<?= site_url('user/profile') ?>" class="text-muted text-decoration-none" style="font-size:.82rem">Annuler</a>
                    <button type="submit" class="btn btn-save">Enregistrer les modifications</button>
                </div>

            <?= form_close() ?>

            <!-- Zone danger -->
            <div class="danger-zone p-3 d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                <div>
                    <p class="mb-1 fw-500" style="font-size:.85rem">Supprimer mon compte</p>
                    <p class="mb-0 text-muted" style="font-size:.78rem">Cette action est irréversible. Toutes vos données seront effacées.</p>
                </div>
                <button type="button" class="btn btn-danger-soft"
                        onclick="confirm('Êtes-vous sûr ? Cette action est définitive.') && window.location.href='<?= site_url('user/delete') ?>'">
                    Supprimer
                </button>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>