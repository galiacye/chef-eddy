<?php

/**
 * @var \App\Entities\Recipe $recipe
 * @var array $tags
 * @var array $ingredients
 * @var array $comments
 * @var int $user_id
 */
?>

<?= $this->extend('layout') ?>
<?= $this->section('meta_description') ?>
<?= esc(mb_substr(strip_tags($recipe->content), 0, 155)) ?><?= $this->endSection() ?>
<!-- mb_substr enlève les balises html. ici de 0 à 155 caractères-->
<?= $this->section('title') ?>
<title>Recette de <?= esc($recipe->title) ?></title>
<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/recipes/recipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<?php
$user_id = session()->get('user_id');

$isFav = false;
if ($user_id) {
    $favoriteModel = model('FavoriteModel');
    $isFav = $favoriteModel->isFavorite($user_id, $recipe->id);
}
?>
<div class="container recipe-page">

    <div class="banner">

        <div class="banner-left">
            <div class="tags">
                <?php foreach ($tags as $tag): ?>
                    <span class="tag"><?= esc($tag->name) ?></span>
                <?php endforeach ?>
            </div>

            <h1 class="recipe-title">
                <?= esc($recipe->title) ?>
            </h1>

            <?php if (!empty($recipe->image_url)): ?>
                <img src="<?= base_url($recipe->image_url) ?>" class="recipe-img">
            <?php endif; ?>
        </div>

        <div class="banner-right">
            <div class="info-card">
                <div>Difficulté : <b><?= esc($recipe->difficulty) ?></b></div>
                <div>Préparation : <b><?= esc($recipe->prep_time) ?> min</b></div>
                <div>Cuisson : <b><?= esc($recipe->cook_time) ?> min</b></div>
                <div>Personnes : <b><?= esc($recipe->portions) ?></b></div>
            </div>
        </div>

    </div>


    <section class="card-block">
        <h2>Ingrédients</h2>

        <div class="ingredients-grid">
            <div class="portions-control">
                <label>Portions :</label>
                <button type="button" id="moins">- </button>
                <span id="portions"><?= esc($recipe->portions) ?></span>
                <button type="button" id="plus">+</button>
            </div>
            <?php foreach ($ingredients as $ingredient): ?>
                <div class="ingredient-card">
                    <b><?= esc($ingredient->name) ?></b>
                    <div>
                        <span class="ingredient-qty" data-base="<?= $ingredient->quantity ?>">
                            <!-- ternaire si entier affiche entier sinon affiche le décimal. 
             C'est la valeur qui servira de base pour le calcul dynamique des portions-->
                            <?= ($ingredient->quantity == (int)$ingredient->quantity) ? (int)$ingredient->quantity : $ingredient->quantity ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="card-block">
        <h2>La recette</h2>
        <div class="editor">
            <?= esc($recipe->content) ?>
        </div>
    </section>

    <?php if ($user_id) : ?>
        <form action="<?= site_url('favorites/toggle/' . (int)$recipe->id) ?>" method="post" class="fav-form">
            <?= csrf_field() ?>
            <button class="btn-fav mb-4 shadow <?= $isFav ? 'active' : '' ?>">
                <?= $isFav ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>
            </button>
        </form>
    <?php endif; ?>


    <section class="card-block comments">
        <h2>Commentaires</h2>
        <?php if (!empty(esc($comments))): ?>
            <?php foreach ($comments as $comment): ?>
                <?php if ($comment->parent_id === null): ?>
                    <div class="comment">
                        <small class="comment-author"><?= esc($comment->username) ?></small>
                        <p><?= esc($comment->content) ?></p>
                        <?php if ($comment->rating): ?>
                            <span class="comment-rating"><?= (int)$comment->rating ?>/5</span>
                        <?php endif ?>

                        <?php foreach ($comments as $reply): ?>
                            <?php if ($reply->parent_id === $comment->id): ?>
                                <div class="comment-reply">
                                    <small class="reply-author">Chef Eddy</small>
                                    <p><?= esc($reply->content) ?></p>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        <?php else: ?>
            <p>Aucun avis pour l'instant</p>
        <?php endif ?>
    </section>

    <a href="/add-comment/<?= $recipe->id ?>" class="btn-action">
        Je l'ai faite
    </a>

</div>
<?= $this->section('customJs') ?>
<script>
    const base = <?= $recipe->portions ?>;
    let current = base;

    const quantities = document.querySelectorAll('.ingredient-qty');

    document.getElementById('moins').addEventListener('click', () => {
        if (current <= 1) return;
        current--;
        update();
    });

    document.getElementById('plus').addEventListener('click', () => {
        current++;
        update();
    });

    function update() {
        document.getElementById('portions').textContent = current;
        quantities.forEach(element => {
            const baseQty = parseFloat(element.dataset.base);
            if (!isNaN(baseQty)) {
                const result = (baseQty * current / base);
                //une simple règle de trois permet de recalculer dynamiquement les portions
                element.textContent = parseFloat(result.toFixed(2)); 
                //parseFloat supprime les zéros après la virgule
            }
        });
    }
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>