<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('./css/showUser.css')?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>


<div class="ban">
        <h1><?= 'Bonjour ' . $user->username . '<br>' ?></h1>
        <img src="<?= base_url($user->avatar_url) ?>" alt="avatar" class="avatar">
</div>
<?= $user->prenom .' '. $user->nom .'<br>'. $user->email ?>

<?= $this->endSection() ?>