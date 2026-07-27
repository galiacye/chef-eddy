<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Index Utilisateurs<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/Admin/users-index.css') ?>" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    body {
        background-color: #efe2c5;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('body') ?>
<div class="container-fluid m-3">
    <div class="row m-3">
<div class="users-grid">
        <?php foreach ($users as $user): ?>
            <div class="card user-card">
                    <div class="card-img-top">
                        <img src="<?= $user->avatar_url ? base_url($user->avatar_url) : base_url('uploads/avatars/fantome.png') ?>" class="avatar">
                    </div>

                    <h4 class="text-center"><span><?= esc($user->username) ?></span></h4>

                    <a href="<?= base_url('Admin/user-details/' . $user->id) ?>" class="btn btn-gerer">Gérer</a>

            </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>