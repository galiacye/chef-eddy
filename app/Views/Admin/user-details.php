<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Détails utilisateur<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    .avatar {
        height: 150px;
        width: 150px;
    }

    .status {
        color: orange;
        font-style: italic;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('body') ?>
<div class="container-fluid mt-3">

    <h2><?= esc($user->username) ?></h2>
    <img src="<?= $user->avatar_url ? base_url($user->avatar_url) : base_url('uploads/avatars/fantome.png') ?>" alt="avatar" class="avatar mb-3">



    <p><?= esc($user->last_name) . ' ' . esc($user->first_name) ?></p>
    <p><?= esc($user->email) ?></p>

    <form action="<?= base_url('Admin/changeUserRole/' . $user->id) ?>" method="post">
        <select name="role_id">
            <option value="1" <?= $user->role_id == 1 ? 'selected' : '' ?>>Guest</option>
            <option value="2" <?= $user->role_id == 2 ? 'selected' : '' ?>>Author</option>
            <option value="3" <?= $user->role_id == 3 ? 'selected' : '' ?>>Admin</option>
            <option value="4" <?= $user->role_id == 4 ? 'selected' : '' ?>>Banned</option>
        </select>
        <button type="submit" class="btn btn-warning">Mettre à jour</button>
    </form>

    <a href="<?= base_url('Admin/deleteUser/' . $user->id) ?>"
        onclick="return confirm('Supprimer cet utilisateur ?')"
        class="btn btn-danger">Supprimer</a>

    <h3>Recettes de <?= esc($user->username) ?></h3>
    <?php foreach ($recipes as $recipe): ?>
        <p> <?= esc($recipe->title) ?> : <span class="status"><?= esc($recipe->status) ? esc($recipe->status) : 'en attente' ?></span></p>
    <?php endforeach ?>
</div>
<?= $this->endSection() ?>