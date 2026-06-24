<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
<title>S'inscrire - Chef Eddy</title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/Auth/register.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<p class="text-center mt-4">Cliquez sur "Déjà membre" ou</p> 
<h1 class="text-center mt-2">Inscrivez-vous</h1>

<div class="row align-items-center g-2 mt-0">

    <div class="col-12 col-md-6 order-2 order-md-1 formul  d-flex flex-column align-items-center justify-content-center">
        <!--order vient de flexbox donc native pour bs
    order-1 order-md-2  -> sur mobile : position 1 (en premier)
                       sur desktop : position 2 (à droite)

order-2 order-md-1   -> sur mobile : position 2 (en dessous)
                       sur desktop : position 1 (à gauche) -->
        <?= form_open_multipart('register') ?>
<!--form_open_miltipart nat ci4 se charge du csrf()-->
        <?php
        $username = [
            'name' => 'username',
            'id' => 'username',
            'value' => set_value('username'),
            'class' => 'form-control w-100'
        ];

        $email = [
            'name' => 'email',
            'id' => 'email',
            'value' => set_value('email'),
            'class' => 'form-control w-100'
        ];

        $password = [
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'class' => 'form-control w-100'
        ];

        $confirm_password = [
            'name'  => 'confirm_password',
            'id'    => 'confirm_password',
            'type'  => 'password',
            'class' => 'form-control w-100'
        ];

        $last_name = [
            'name'  => 'last_name',
            'id'    => 'last_name',
            'value' => set_value('last_name'),
            'class' => 'form-control w-100'
        ];
        $first_name = [
            'name'  => 'first_name',
            'id'    => 'first_name',
            'value' => set_value('first_name'),
            'class' => 'form-control w-100'
        ];

        $avatar = [
            'name' => 'avatar_url',
            'id' => 'avatar_url',
            'class' => 'form-control w-100',
        ];
      
        ?>

        <?= form_fieldset("Vos Informations", ['class' => 'border p-4']) ?>

        <!--  helper('form') est chargé globalement dans BaseController (maintenant)-->
        <label for="username">Pseudo</label>
        <?= form_input($username) ?>
        <?= validation_show_error('username') ?>

        <label for="email">Email</label>
        <?= form_input($email) ?>
        <?= validation_show_error('email') ?><br>

        <label for="password">Mot de passe</label>
        <?= form_input($password) ?>
        <?= validation_show_error('password') ?><br>

        <label for="confirm_password">Confirmer le mot de passe</label>
        <?= form_input($confirm_password) ?>
        <?= validation_show_error('confirm_password') ?><br>

        <label for="avatar_url">Avatar</label>
        <?= form_upload($avatar) ?>
        <?= validation_show_error('avatar_url') ?><br>

        <?= form_fieldset_close() ?>

        <div class="container text-center mt-3">
            <?= form_submit('submit', 'Inscription', ['class' => 'btn btn-custom']) ?>
        </div>

        <?= form_close() ?>

    </div>
    <div class="col-12 col-md-6 order-1 order-md-2 d-flex align-items-center justify-content-center">
      
          
                <img src="<?= base_url('img/logo.png') ?>"
                    class="pink-cake img-fluid"
                    alt="pink-cake">
            </div>
       
       
    </div>
</div>

<?= $this->endSection() ?>