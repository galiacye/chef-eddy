<?= $this->extend('layout') ?>
<?= $this->section('title') ?>
<h1 class="text-center mt-4">Modifier vos données personnelles</h1>
<?= $this->endSection() ?>
<?= $this->section('customcss') ?>
<link href="/assets/css/profile.css" rel="stylesheet">
<?= $this->endSection() ?>
<?= $this->section('body') ?>

<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <nav class="navbar mb-3">
                <a href="<?= site_url('/') ?>">Accueil</a>
                <a href="<?= site_url('User/profile') ?>">Mon compte</a>
            </nav>

            <h1 class="fs-5 fw-500 mb-1">Mes informations</h1>
            <p class="text-muted mb-4">Modifiez vos informations personnelles et de connexion.</p>


            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success py-2 px-3">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger py-2 px-3">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?= form_open('User/updateProfile') ?>


            <div class="card border mb-3" style="border-radius:6px;">
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

            <div class="d-flex align-items-center justify-content-between mb-5">
                <a href="<?= site_url('User/profile') ?>" class="text-muted text-decoration-none">Annuler</a>
                <button type="submit" class="btn btn-save">Enregistrer les modifications</button>
            </div>

            <?= form_close() ?>

            <div class="danger-zone p-3 d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-3">
                <div>
                    <p class="mb-1 fw-500">Supprimer mon compte</p>
                    <p class="mb-0 text-muted">Cette action est irréversible. Toutes vos données seront effacées.</p>
                </div>
                <form action="<?= base_url('delete/profile/' . $user_id) ?>" method="post">
                                
                </form>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->endSection() ?>

</html>