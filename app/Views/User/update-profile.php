<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
<title>update-profile</title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/user/update-profile.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>


<?= $this->section('body') ?>

<h1 class="text-center mt-3">Modifier vos données</h1>
<div class="row justify-content-center align-items-center">
    <div class="col-12 col-md-6 col-lg-4">
        <?= form_open_multipart('profile/update') ?>

        <?php
        $username = [
            'name' => 'username',
            'id' => 'username',
            'value' => set_value('username', $user->username),
            'class' => 'form-control w-100 shadow'
        ];

        $email = [
            'name' => 'email',
            'id' => 'email',
            'value' => set_value('email', $user->email),
            'class' => 'form-control w-100 shadow'
        ];

        $password = [
            'name' => 'password',
            'id' => 'password',
            'type' => 'password',
            'class' => 'form-control w-100 shadow'
        ];

        $last_name = [
            'name' => 'last_name',
            'id' => 'last_name',
            'value' => set_value('last_name', $user->last_name),
            'class' => 'form-control w-100 shadow'
        ];

        $first_name = [
            'name' => 'first_name',
            'id' => 'first_name',
            'value' => set_value('first_name', $user->first_name),
            'class' => 'form-control w-100 shadow'
        ];

        $avatar = [
            'name' => 'avatar_url',
            'id' => 'avatar_url',
            'class' => 'form-control w-100 shadow'
        ];

        ?>

        <?= form_fieldset("Informations vous concernant", ['class' => 'p-2']) ?>

        <label for="username">Pseudo</label>
        <?= form_input($username) ?>
        <?= validation_show_error('username') ?><br>

        <label for="email">Email</label>
        <?= form_input($email) ?>
        <?= validation_show_error('email') ?><br>

        <label for="password">Mot de passe</label>
        <placeholder>Laissez vide si vous ne voulez pas changer</placeholder>
        <?= form_input($password) ?>
        <?= validation_show_error('password') ?><br>

        <label for="last_name">Nom (facultatif)</label>
        <?= form_input($last_name) ?>
        <?= validation_show_error('last_name') ?><br>

        <label for="first_name">Prénom (facultatif)</label>
        <?= form_input($first_name) ?>
        <?= validation_show_error('first_name') ?><br>

        <label for="avatar_url">Avatar</label>
        <?php if (!empty($user->avatar_url)): ?>
            <img src="<?= base_url($user->avatar_url) ?>" alt="avatar actuel" width="80" class="d-block mb-2">
        <?php endif ?>
        <?= form_upload($avatar) ?>
        <?= validation_show_error('avatar_url') ?><br>

        <?= form_fieldset_close() ?>

        <div class="container-action text-center mt-3">
            <?= form_submit('submit', 'Enregistrer les modifications', ['class' => 'btn btn-blue shadow']) ?>
        </div>
    </div>
</div>
<?= form_close() ?>

<?= form_open('delete-profile') ?>

<div class="text-center mt-2">
    <?= form_submit('delete', 'Supprimer votre compte', ['class' => 'btn btn-coral shadow']) ?>
</div>
<!--ajouter un modal de confirmation pour éviter suppression accidentelle-->
<?= form_close() ?>

<?= $this->endSection() ?>