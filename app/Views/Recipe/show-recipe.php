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

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/recipes/crecipe.css') ?>" rel="stylesheet">
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
                    <span class="tag"><?= $tag->nom ?></span>
                <?php endforeach ?>
            </div>

            <h1 class="recipe-title">
                <?= $recipe->titre ?>
            </h1>

            <?php if (!empty($recipe->image_url)): ?>
                <img src="<?= base_url($recipe->image_url) ?>" class="recipe-img">
            <?php endif; ?>
        </div>

        <div class="banner-right">
            <div class="info-card">
                <div>Difficulté : <b><?= $recipe->difficulte ?></b></div>
                <div>Préparation : <b><?= $recipe->temps_preparation ?> min</b></div>
                <div>Cuisson : <b><?= $recipe->temps_cuisson ?> min</b></div>
                <div>Personnes : <b><?= $recipe->nb_personnes ?></b></div>
            </div>
        </div>

    </div>


    <section class="card-block">
        <h2>Ingrédients</h2>

        <div class="ingredients-grid">
            <div class="portions-control">
                <label>Portions :</label>
                <button type="button" id="moins">-</button>
                <span id="nb-personnes"><?= $recipe->nb_personnes ?></span>
                <button type="button" id="plus">+</button>
            </div>
            <?php foreach ($ingredients as $ingredient): ?>
                <div class="ingredient-card">
                    <b><?= $ingredient->nom ?></b>
                    <div>
                        <span class="ingredient-qty" data-base="<?= $ingredient->quantite ?>">
                            <?= $ingredient->quantite ?>
                        </span> <?= $ingredient->unite ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="card-block">
        <h2>La recette</h2>
        <div class="editor">
            <?= $recipe->contenu ?>
        </div>
    </section>

    <?php if ($user_id) : ?>
        <form action="<?= site_url('favorites/toggle/' . $recipe->id) ?>" method="post" class="fav-form">
            <?= csrf_field() ?>
            <button class="btn-fav <?= $isFav ? 'active' : '' ?>">
                <?= $isFav ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>
            </button>
        </form>
    <?php endif; ?>


    <section class="card-block comments">
        <h2>Commentaires</h2>

        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p><?= $comment->content ?></p>
                    <span><?= $comment->rating ?>/5</span>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <p>Aucun avis pour l'instant</p>
        <?php endif ?>
    </section>

    <a href="/add-comment/<?= $recipe->id ?>" class="btn-action">
        Je l'ai faite
    </a>

</div>
<?= $this->section('customJs') ?>
<script>
    const base = <?= $recipe->nb_personnes ?>;
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
        document.getElementById('nb-personnes').textContent = current;
        quantities.forEach(el => {
            const baseQty = parseFloat(el.dataset.base);
            if (!isNaN(baseQty)) {
                const result = (baseQty * current / base);
                el.textContent = Number.isInteger(result) ? result : result.toFixed(2);
            }
        });
    }
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>