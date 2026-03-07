<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/userIndex.css')?> rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<?php foreach($users as $user):?>
    <h1><?= $user->username ?></h1>
<?php endforeach ?>
<?= $this->endSection() ?>


