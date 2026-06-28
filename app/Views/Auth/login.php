<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/Auth/login.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<?= form_open('login') ?>

<div class="row justify-content-center align-items-center">
    <h1 class="text-center mt-4">Connexion</h1>
    <div class="infos col-4">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control w-100 shadow" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control w-100 shadow" required>
        <div class="connect">

            <button type="submit" class="btn btn-blue my-4 shadow">Se connecter</button>

            <a href="<?= base_url('forgot-password') ?>">Mot de passe oublié ?</a>
        </div>
        <?= form_close() ?>
    </div>
    <?= $this->endSection() ?>