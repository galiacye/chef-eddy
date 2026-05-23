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
            <div class="row row-cols-1 row-cols-md-3 g-3">
                <?php foreach ($userRecipes as $recipe) : ?>
                    <div class="col">
                        <div class="card bg-dark text-light h-100 shadow-sm border-secondary">
                            <div class="card-body d-flex flex-column justify-content-between">

                                <h5 class="card-title mb-3">
                                    <?= esc($recipe->titre) ?>
                                </h5>

                                <?php if ($isOwnProfile) : ?>
                                    <div class="mt-auto">
                                        <a href="<?= base_url('update-recipe/' . $recipe->id) ?>"
                                            class="btn btn-sm btn-info w-100">
                                            Modifier
                                        </a>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else : ?>
            <div class="text-center py-5">
                <p class="text-light mb-0 fs-5">
                    Aucune recette pour l'instant.
                </p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Commentaires -->
<div class="row comments py-4">
    <h4 class="text-center text-light">Commentaires</h4>
    <?php if (!empty($comments)) : ?>
        <?php foreach ($comments as $comment) : ?>
            <?php if ($comment->parent_id === null) : ?>
                <div class="col-12 mb-3">
                    <!-- Commentaire utilisateur -->
                    <div class="p-3 bg-dark text-light border border-secondary rounded">
                        <small class="text-muted"><?= esc($comment->username) ?></small>
                        <p class="mb-1 mt-1"><?= $comment->content ?></p>
                        <?php if ($comment->rating) : ?>
                            <small class="text-warning"><?= $comment->rating ?>/5</small>
                        <?php endif ?>
                    </div>

                    <!-- Réponse du chef si elle existe -->
                    <?php foreach ($comments as $reply) : ?>
                        <?php if ($reply->parent_id === $comment->id) : ?>
                            <div class="p-3 ms-4 mt-2 bg-secondary text-light rounded">
                                <small class="text-warning">Chef Eddy</small>
                                <p class="mb-0 mt-1"><?= $reply->content ?></p>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    <?php else : ?>
        <p class="text-center text-light">Aucun commentaire pour l'instant.</p>
    <?php endif ?>
</div>
</div>
<?= $this->endSection() ?>