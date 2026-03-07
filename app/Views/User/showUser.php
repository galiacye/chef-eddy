<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="./css/oneUser.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>


<div class="ban">
        <h1><?= 'Bonjour ' . $user->username . '<br>' ?></h1>
        <img src="<?= base_url($user->avatar_url) ?>" alt="avatar" style="height:400px;width:300px;border:3px solid red;">
</div>
<?= $user->prenom .' '. $user->nom .'<br>'. $user->email ?>

<?= $this->endSection() ?>