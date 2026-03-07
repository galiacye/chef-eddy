<?= $this->extend('layout') ?>

<?= $this->section('custom-css')?>
<link href="./css/eddy.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

        <h1><?= 'Bonjour '.$user->username. '<br>'?></h1>
        <img src="<?= base_url($user->avatar_url) ?>" alt="fraisier" style="width:300px;border:3px solid red;">
       
<?= $this->endSection() ?>