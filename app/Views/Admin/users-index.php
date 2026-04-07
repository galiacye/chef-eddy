<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Index Utilisateurs<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    body {
        background-image: url('<?= base_url('img/topo.png') ?>');
        background-size: cover;
    }

    .grenade-list {
        list-style: none;
        padding-left: 0;
    }

    .grenade-list li {
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .grenade-icon {
        color: #ff8800;
        /* couleur grenat/orange */
        cursor: pointer;
        font-size: 1rem;
        transition: transform 0.2s;
    }

    .grenade-icon:hover {
        transform: scale(1.2);
        color: red;
    }
    .avatar {
        height: 100px;
        border-radius: 50%;
    }
</style>
<?= $this->endSection() ?>
<?= $this->section('body') ?>
<div class="container-fluid m-3">
    <div class="row m-3">
        <ul class="grenade-list">

            <?php foreach ($users as $user): ?>
                <li>
                    <div class="col m-3">

                        <h4 class="text-light"><span class="text-light"><?= $user->username?></span></h4>

                        <img src="<?= $user->avatar_url ? base_url($user->avatar_url) : base_url('uploads/avatars/fantome.png') ?>" class="avatar">
                       
                        <i class="fa-solid fa-bomb grenade-icon" onclick="alert('Grenade 1 cliquée !')">voir, modifier, supprimer ici</i>
                         <a href="<?= base_url('Admin/user-details/' . $user->id) ?>" class="btn btn-primary">Gérer</a> 

                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>

<?= $this->endSection() ?>