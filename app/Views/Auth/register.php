<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
<title>S'inscrire - Chef Eddy</title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/Auth/register.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<p class="text-center mt-4 member">Cliquez sur "Déjà membre" ou</p>
<h1 class="text-center mt-2">Inscrivez-vous</h1>

    <div class="row justify-content-center align-items-center">
        <div class="col-4">

            <!--<div class="col-12 col-md-6 order-2 order-md-1 formul  d-flex flex-column align-items-center justify-content-center">-->
            <!--order vient de flexbox donc native bs
    order-1 order-md-2: sur mobile en position 1 (en premier)
                        sur desktop en position 2 (à droite)

    order-2 order-md-1: sur mobile : position 2 (en dessous)
                        sur desktop : position 1 (à gauche) -->
            <?= form_open_multipart('register') ?>
            <!--form_open_miltipart nat ci4 se charge du csrf()-->
            <!--ici par rapport à login en html avec input type, on utilise le helper form de ci4,
            qui génère tout seul le html, et pour set_value qui conserve la saisie après echec valid.
            <?php
            $username = [
                'name' => 'username',
                'id' => 'username',
                'value' => set_value('username'),
                'class' => 'form-control w-100 shadow'
            ];

            $email = [
                'name' => 'email',
                'id' => 'email',
                'value' => set_value('email'),
                'class' => 'form-control w-100 shadow'
            ];

            $password = [
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'class' => 'form-control w-100 shadow'
            ];

            $confirm_password = [
                'name'  => 'passconf',
                'id'    => 'passconf',
                'type'  => 'password',
                'class' => 'form-control w-100 shadow'
            ];

            $last_name = [
                'name'  => 'last_name',
                'id'    => 'last_name',
                'value' => set_value('last_name'),
                'class' => 'form-control w-100 shadow'
            ];
            $first_name = [
                'name'  => 'first_name',
                'id'    => 'first_name',
                'value' => set_value('first_name'),
                'class' => 'form-control w-100 shadow'
            ];

            $avatar = [
                'name' => 'avatar_url',
                'id' => 'avatar_url',
                'class' => 'form-control w-100 shadow',
            ];

            ?>
            <!--  helper('form') est chargé globalement dans BaseController (maintenant)-->
        
            <div class="mb-2">
                <label for="username" class="form-label">Pseudo</label>
                <?= form_input($username) ?>
                <?= validation_show_error('username') ?>
            </div>

            <div class="mb-2">
                <label for="email" class="form-label">Email</label>
                <?= form_input($email) ?>
                <?= validation_show_error('email') ?>
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">Mot de passe</label>
                <?= form_input($password) ?>
                <?= validation_show_error('password') ?>
            </div>

            <div class="mb-2">
                <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                <?= form_input($confirm_password) ?>
                <?= validation_show_error('confirm_password') ?>
            </div>

            <label for="avatar_url">Avatar</label>
            <?= form_upload($avatar) ?>
            <?= validation_show_error('avatar_url') ?><br>

            <div class="container text-center">
                <?= form_submit('submit', 'Inscription', ['class' => 'btn btn-custom']) ?>
            </div>

            <?= form_close() ?>

        </div>

    </div>

    <?= $this->endSection() ?>