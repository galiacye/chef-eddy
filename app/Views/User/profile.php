<?= $this->extend('layout') ?>
<?= $this->section('custom-css') ?>
<link href="<?= base_url('./css/user/profile.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container">

    <!-- En-tête -->
    <div class="row align-items-center justify-content-around py-4 py-md-5">
        <div class="col-auto">
            <h1 class="text-light">Profil de <span><?= esc($user->username) ?></span></h1>
        </div>
        <div class="col-auto">
            <div class="avatar-wrap">
                <div class="avatar">
                    <?php if (! empty($user->avatar_url)) : ?>
                        <img src="<?= base_url($user->avatar_url) ?>" alt="Avatar" class="avatar">
                    <?php else : ?>
                        <?= strtoupper(mb_substr($user->username, 0, 1)) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Recettes -->
    <div class="row recipes">
        <h4 class="text-center text-light">
            <?= $isOwnProfile ? 'Mes recettes' : 'Recettes de ' . esc($user->username) ?>
        </h4>

        <?php if (! empty($userRecipes)) : ?>
            <?php foreach ($userRecipes as $recipe) : ?>
                <div class="col">
                    <p><?= esc($recipe->title) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center text-light">Aucune recette pour l'instant.</p>
        <?php endif; ?>
    </div>

    <!-- Commentaires -->
    <div class="row comments py-4">
        <h4 class="text-center text-light">Commentaires</h4>

        <?php if (! empty($comments)) : ?>
            <?php foreach ($comments as $comment) : ?>
                <div class="col">
                    <p><?= esc($comment->content) ?></p> <!-- adapte le nom du champ -->
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center text-light">Aucun commentaire pour l'instant.</p>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>