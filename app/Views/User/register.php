<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
    Register
<?= $this->endSection() ?>

<?= $this->section('custom-css')?>
    <link href="User/register.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

    <h1 class="text-center">S'inscrire</h1>

    <?= form_open_multipart('User/register') ?>

<?php
$username = [
    'name' => 'username',
    'id' => 'username',
    'value' => set_value('username'),
    'class' => 'form-control w-50'
];

$email = [
    'name' => 'email',
    'id' => 'email',
    'value' => set_value('email'),
    'class' => 'form-control w-50'
];

$password = [
    'name' => 'password',
    'id' => 'password',
    'type' => 'password',
    'class' => 'form-control w-50'
];

$nom = [
    'name' => 'nom',
    'id' => 'nom',
    'value' => set_value('nom'),
    'class' => 'form-control w-50'
];

$prenom = [
    'name' => 'prenom',
    'id' => 'prenom',
    'value' => set_value('prenom'),
    'class' => 'form-control w-50'
];

$avatar = [
    'name' => 'avatar_url',
    'id' => 'avatar_url',
    'class' => 'form-control w-50',
];
$rolesOptions = ['' => 'Sélectionnez un rôle'];
foreach ($roles as $role) {
    $rolesOptions[$role->id] = $role->nom;
}
?>



<?= form_fieldset("Informations de l'utilisateur", ['class' => 'border p-4']) ?>

<!-- ici pas d'utilisation de helper('form')-->
<label for="username">Pseudo</label>
<?= form_input($username) ?>
<?= validation_show_error('username') ?>

<label for="email">Email</label>
<?= form_input($email) ?>
<?= validation_show_error('email') ?><br>

<label for="password">Mot de passe</label>
<?= form_input($password) ?>
<?= validation_show_error('password') ?><br>

<label for="nom">Nom</label>
<?= form_input($nom) ?>
<?= validation_show_error('nom') ?><br>

<label for="prenom">Prénom</label>
<?= form_input($prenom) ?>
<?= validation_show_error('prenom') ?><br>

<label for="avatar_url">Avatar</label>
<?= form_upload($avatar) ?>
<?= validation_show_error('avatar_url') ?><br>



<label for="role_id">Rôle</label>
<?= form_dropdown('role_id', $rolesOptions, set_value('role_id'), ['class' => 'form-control w-50']) ?>
<?= validation_show_error('role_id') //$role_id récupéré par la session?>


<?= form_fieldset_close() ?>

<div class="container text-center mt-3">
    <?= form_submit('submit', 'Créer l’utilisateur', ['class' => 'btn btn-info']) ?>
</div>

<?= form_close() ?>

<?= $this->endSection() ?>

