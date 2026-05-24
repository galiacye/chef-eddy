<?= $this->extend('layout') ?>
<?= $this->section('custom-css') ?>
<style>
body {
    background-color: pink;
}
</style>
<?= $this->endSection() ?>
<?= $this->section('body') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Réinitialiser mon mot de passe</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div><!--ici je ne l'ai pas factorisé en $error pour garder l'exemple-->
            <?php endif ?>

            <?php if (isset($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <?= form_open('reset-password/' . $token) ?>

                <div class="mb-3">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password"
                           class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password">Confirmer le mot de passe</label>
                    <input type="password" name="confirm_password" id="confirm_password"
                           class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Réinitialiser</button>

            <?= form_close() ?>

            <a href="<?= base_url('login') ?>" class="d-block mt-3">Retour à la connexion</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>