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
<link href="<?= base_url('css/recipes/showRecipe.css')?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<div class="banner">
    <div class="title-and-tags">
        
        <?php foreach($tags as $tag): ?>
            <h2><?= $tag->nom ?></h2>
        <?php endforeach ?>
        <h1><?= $recipe->titre ?></h1>
    </div>

    <div class="illustration">
        <?php if($recipe->image_url): ?>
            <img src="<?= base_url($recipe->image_url ?? 'img/default.jpg') ?>" alt="image recette" class="recipe-img">
        <?php endif ?>
    </div>
</div>
<div class="infos">
    <p>Difficulté : <?= $recipe->difficulte ?></p>
    <p>Temps de préparation : <?= $recipe->temps_preparation ?> minutes</p>
    <p>Temps de cuisson : <?= $recipe->temps_cuisson ?> minutes</p>
    <p>Nombre de personnes : <?= $recipe->nb_personnes ?></p>
</div>

<div class="ingredients">
                <h3>Ingredients</h3>
                <ul>
                <?php foreach($ingredients as $ingredient):?>
                        <li><?= $ingredient->nom ?> : <?= $ingredient->quantite ?> . <?= $ingredient->unite ?></li>
                <?php endforeach ?>
                </ul>
</div>
     

<!-- pour quill-js : -->
<div class="editor">
        <p><?= $recipe->contenu ?></p>
</div>

<div class="comment m-4">
    <h3>Voir les avis</h3>
    <?php if(!empty($comments)): ?>
        <?php foreach($comments as $comment): ?>
            <div class="comment m-3">
                <p><?= $comment->content ?></p>
                <p>Note : <?= $comment->rating ?>/5</p>
            </div>
        <?php endforeach ?>
    <?php else : ?>
        <p>Aucun avis pour l'instant</p>
        <?php endif ?>
</div>


<a href="/add-comment/<?= $recipe->id ?>" class="btn btn-success btn-lg m-3">Je l'ai faite</a>

<?= $this->endSection() ?>


