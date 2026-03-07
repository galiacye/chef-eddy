<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
   Update User
<?= $this->endSection() ?>

<?= $this->section('custom-css')?>
    <link href="addUser.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

    <h1 class="text-center">Modifier vos données</h1>

    <?= form_open_multipart('/user/add') ?>

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
    'class' => 'form-control w-50'
];

$role_id = [
    'name' => 'role_id',
    'id' => 'role_id',
    'class' => 'form-control w-50'
]

?>

<?= form_fieldset("Informations de l'utilisateur", ['class' => 'border p-4']) ?>

<label for="username">Pseudo</label>
<input type="text" id="username" name="username" value="<?= set_value('username', $user->username) ?>">
<?= validation_show_error('username') ?><br>

<label for="email">Email</label>
<input type="email" id="email" name="email" value="<?= set_value('email',$user->email) ?>">
<?= validation_show_error('email') ?><br>

<label for="password">Mot de passe</label>
<input type="password" id="password" name="password">
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



<?= form_fieldset_close() ?>

<div class="container text-center mt-3">
    <?= form_submit('submit', 'Créer l’utilisateur', ['class' => 'btn btn-info']) ?>
</div>

<?= form_close() ?>

<?= $this->endSection() ?>

