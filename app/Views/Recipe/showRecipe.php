<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="./css/showRecipe.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<div class="banner">
    <h1><?= $recipe->titre ?></h1>
    <?php foreach($tags as $tag): ?>
        <h2><?= $tag->nom_tag ?></h2>
    <?php endforeach ?>
    <?php if($recipe->image_url): ?>
        <img src="<?= base_url($recipe->image_url) ?>" alt="image recette">
    <?php endif ?>
    <p><?= $recipe->difficulte ?></p>
    <p><?= $recipe->temps_preparation ?></p>
    <p><?= $recipe->temps_cuisson ?></p>
    <p><?= $recipe->nb_personnes ?></p>
</div>

<div class="ingredients">
                <h3>Ingredients</h3>
                <ul>
                <?php foreach($ingredients as $ingredient):?>
                        <li><?= $ingredient->nom ?></li>
                <?php endforeach ?>
                </ul>
</div>
     

<!-- pour quill-js : -->
<div class="editor">
        <p><?= $recipe->contenu ?>
</div>



<?= $this->endSection() ?>