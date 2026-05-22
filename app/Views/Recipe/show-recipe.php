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
<div class="container-fluid">

    <div class="banner d-flex flex-column flex-md-row align-items-center justify-content-between">

        <div class="title-and-tags text-center text-lg-start">
            <?php foreach ($tags as $tag): ?>
                <h2 class="tagName"><?= $tag->nom ?></h2>
            <?php endforeach ?>

            <h1 class="recipeTitle ms-lg-4 my-0">
                <?= $recipe->titre ?>
            </h1>
            <div class="illustration">
                <?php if (!empty($recipe->image_url)): ?>
                    <img src="<?= base_url($recipe->image_url) ?>"
                        alt="image recette"
                        class="recipe-img mt-2">
                <?php endif; ?>
            </div>
        </div>

        <div class="container ingredients mt-4">

                <h3 class="ingTitle">Les Ingrédients</h3>

                <div class="row g-4 justify-content-center">

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




        <div class="infos d-flex flex-column gap-2 justify-content-center align-items-center me-4">
            <div><span class="info">Difficulté : </span><?= $recipe->difficulte ?></div>
            <div><span class="info">Préparation : </span><?= $recipe->temps_preparation ?> min</div>
            <div><span class="info">Cuisson : </span><?= $recipe->temps_cuisson ?> min</div>
            <div><span class="info">Personnes : </span><?= $recipe->nb_personnes ?></div>
        </div>

    </div>

</div>
<div class="row my-2 mx-4">

</div>

<h2 class="larecette text-center">La Recette</h2>
<!-- pour quill-js : -->
<div class="recipe-bloc container-fluid me-4">
    <div class="editor">
        <?= $recipe->contenu ?>
    </div>
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



<div class="comment-bloc m-4">
    <h3>Les commentaires</h3>
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comments m-3">
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