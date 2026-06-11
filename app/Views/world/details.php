<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
<title>Recette de <?= esc($meal['strMeal']) ?></title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/recipes/crecipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container recipe-page">

    <div class="banner">
        <div class="banner-left">

         <!-- Tags : pays et catégorie TheMealDB  -->
            <div class="tags">
                <span class="tag"><?= esc($meal['strArea']) ?></span><!--clé du tab json de l'api-->
                <span class="tag"><?= esc($meal['strCategory']) ?></span>
            </div>

            <h1 class="recipe-title"><?= esc($meal['strMeal']) ?></h1>

            <?php if (!empty($meal['strMealThumb'])): ?>
             <!--l'img hebergée par l'api-->
                <img src="<?= esc($meal['strMealThumb']) ?>" class="recipe-img" alt="<?= esc($meal['strMeal']) ?>">
            <?php endif ?>

        </div>
    </div>

    <section class="card-block">
        <h2>Ingrédients</h2>
        <div class="ingredients-grid">
            <?php
            // TheMealdb stocke les ingrédients dans 20 champs numérotés (strIngredient1 à strIngredient20)
            // on boucle et on ignore les champs vides
            for ($i = 1; $i <= 20; $i++):
                $ingredient = $meal['strIngredient' . $i] ?? '';
                $unit       = $meal['strMeasure' . $i]    ?? '';
                if (empty(trim($ingredient))) continue;//passe au suivant sans exec le reste
            ?>
                <div class="ingredient-card">
                    <b><?= esc($ingredient) ?></b>
                    <div><?= esc($unit) ?></div>
                </div>
            <?php endfor ?>
        </div>
    </section>

    <section class="card-block">
        <h2>La recette</h2>
    <!-- nl2br pour respecter les sauts de ligne du texte brut retourné par l'API -->
        <div class="editor">
            <?= nl2br(esc($meal['strInstructions'])) ?>
        </div>
    </section>

    <a href="<?= site_url('cuisine-du-monde') ?>" class="btn-action">
       Retour en cuisine
    </a>

</div>
<?= $this->endSection() ?>