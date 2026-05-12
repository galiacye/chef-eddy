<?= $this->extend('layout') ?>
<?= $this->section('custom-css') ?>
<style>
    body {
    background-color : pink;
}
</style>
<?= $this->endSection() ?>
<?= $this->section('body') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2>Mot de passe oublié</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif ?>

            <?= form_open('forgot-password') ?>
                <div class="mb-3">
                    <label for="email">Votre email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer le lien</button>
            <?= form_close() ?>

            <a href="<?= base_url('login') ?>" class="d-block mt-3">Retour à la connexion</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>