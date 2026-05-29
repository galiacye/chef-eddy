<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/login.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<!-- flashdata = données temporaires de la session -->
 <!--si message d'erreur l'afficher-->
<?php $error = session()->getFlashdata('error') ?>
<?php if ($error) : ?>
    <div class="alert alert-danger">
        <?= $error ?>
    </div>
<?php endif ?>

<?= form_open('login') ?>
<div class="mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>  
    <a href="<?= base_url('forgot-password') ?>">Mot de passe oublié ?</a>

    <button type="submit" class="btn btn-primary">Se connecter</button>
<?= form_close() ?>

<?= $this->endSection() ?>