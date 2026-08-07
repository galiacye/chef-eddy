<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Détails utilisateur<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="<?= base_url('./css/Admin/user-details.css') ?>" rel="stylesheet">

<?= $this->endSection() ?>
<?= $this->section('body') ?>
<div class="container-fluid mt-3">
    <div class="user-card">
        <img src="<?= $user->avatar_url ? base_url($user->avatar_url) : base_url('uploads/avatars/fantome.png') ?>" alt="avatar" class="avatar">
        <div class="user-info">
            <h2><?= esc($user->username) ?></h2>
            <p><?= esc($user->last_name) . ' ' . esc($user->first_name) ?></p>
            <p><?= esc($user->email) ?></p>
        </div>
    </div>
    <div class="user-actions">
        <form action="<?= base_url('Admin/changeUserRole/' . $user->id) ?>" method="post" class="role-form">
            <select name="role_id" class="role-select shadow">
                <option value="1" <?= $user->role_id == 1 ? 'selected' : '' ?>>Guest</option>
                <option value="2" <?= $user->role_id == 2 ? 'selected' : '' ?>>Author</option>
                <option value="3" <?= $user->role_id == 3 ? 'selected' : '' ?>>Admin</option>
                <option value="4" <?= $user->role_id == 4 ? 'selected' : '' ?>>Banned</option>
            </select>
            <button type="submit" class="btn btn-warning shadow">Mettre à jour</button>
        </form>

        <a href="<?= base_url('Admin/deleteUser/' . $user->id) ?>"
            onclick="return confirm('Supprimer cet utilisateur ?')"
            class="btn btn-danger shadow">Supprimer</a>
    </div>

    <h3>Recettes de <?= esc($user->username) ?></h3>
    <table class="recipes-table">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
                <tr>
                    <td data-label="Titre"><?= esc($recipe->title) ?></td>
                    <td data-label="Statut"><span class="status"><?= esc($recipe->status) ? esc($recipe->status) : 'en attente' ?></span></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>
<?= $this->endSection() ?>