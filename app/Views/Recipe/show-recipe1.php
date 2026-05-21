<?php

/**
 * @var \App\Entities\Recipe $recipe
 * @var array $tags
 * @var array $ingredients
 * @var array $comments
 */
?>

<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/recipes/show-recipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container-fluid px-0">
    <div class="row align-items-center banner justify-content-center">

        <div class="col-2 col-md-3 illustration">
            <?php if (!empty($recipe) && !empty($recipe->image_url)): ?>
                <img src="<?= base_url($recipe->image_url) ?>"
                    alt="image recette"
                    class="recipe-img my-2">
            <?php endif; ?>
        </div>

        <div class="col-4 col-md-6 title-and-tags">
            <?php if (!empty($recipe)): ?>

                <?php foreach ($tags as $tag): ?>
                    <h2 class="tagName"><?= $tag->nom ?></h2>
                <?php endforeach ?>
                <h1 class="recipeTitle ms-4">
                    <?= $recipe->titre ?>
                </h1>

            <?php endif; ?>
        </div>

    </div>
</div>

<div class="row infos justify-content-around align-items-center my-2 py-2">
    <div class="col-auto diff">
        Difficulté : <?= $recipe->difficulte ?>
    </div>
    <div class="col-auto t-p">
        Temps de préparation : <?= $recipe->temps_preparation ?> minutes
    </div>
    <div class="col-auto t-c">
        Temps de cuisson : <?= $recipe->temps_cuisson ?> minutes
    </div>
    <div class="col-auto nb">
        Nombre de personnes : <?= $recipe->nb_personnes ?>
    </div>
</div>
<div class="row my-2">
<div class="container ingredients mx-0">

    <h3 class="ingTitle">Ingrédients</h3>

    <div class="row g-3">

        <?php foreach ($ingredients as $ingredient): ?>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="ingredient-card">
                    <strong><?= $ingredient->nom ?></strong><br>

                    <?= $ingredient->quantite ?>
                    <?= $ingredient->unite ?>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>
</div>


<!-- pour quill-js : -->
<div class="editor">
    <p><?= $recipe->contenu ?></p>
</div>



<!--bouton favorites commence ici -->
<?php
$user_id    = session()->get('user_id');
$isFav     = false;
if ($user_id) {
    $favoriteModel = model('FavoriteModel');
    $isFav = $favoriteModel->isFavorite($user_id, $recipe->id);
}
?>

<?php if ($user_id) : ?>
    <form action="<?= site_url('favorites/toggle/' . $recipe->id) ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit" class="btn  <?= $isFav ? 'btn-is' : 'btn-isNot' ?>">
            <?= $isFav ? ' Retirer des favoris' : ' Ajouter aux favoris' ?>
        </button>
    </form>
<?php endif; ?>
<!--et se termine là-->



<div class="comment m-4">
    <h3>Voir les avis</h3>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment m-3">
                <p><?= $comment->content ?></p>
                <p>Note : <?= $comment->rating ?>/5</p>
            </div>
        <?php endforeach ?>
    <?php else : ?>
        <p>Aucun avis pour l'instant</p>
    <?php endif ?>
</div>

</div><!--fin container-->
<a href="/add-comment/<?= $recipe->id ?>" class="btn btn-success btn-lg m-3">Je l'ai faite</a>

<?= $this->endSection() ?>