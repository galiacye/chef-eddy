<?= $this->extend('layout') ?>

<?= $this->section('meta_description') ?>
Résultats pour "Cuisine de <?= esc($country) ?>" sur Chef Eddy
<?= $this->endSection() ?>

<?= $this->section('title') ?>
<title>Cuisine <?= esc($country) ?></title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/world/results.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container">
 <a href="<?= site_url('cuisine-du-monde') ?>" class="btn-action">
   Retour à la liste des pays
    </a>
    <h1 class="recipeTitle mt-2 text-center"><?= esc($country) ?>  Food</h1>

    <?php if (empty($meals)): ?>
      <!-- cas où api ne retourne aucune recette pour ce pays  -->
        <p>Aucune recette trouvée.</p>
    <?php else: ?>
       <!-- grille de recettes, cards en boucle -->
        <div class="d-flex flex-wrap justify-content-center justify-content-md-between gap-2">
            <?php foreach ($meals as $meal): ?>
                <div class="card">
                <a href="<?= site_url('cuisine-du-monde/recipe/' . (int)$meal['idMeal']) ?>" class="recipe-card">
                    <img src="<?= esc($meal['strMealThumb']) ?>" alt="<?= esc($meal['strMeal']) ?>" class="card-img-top">
                    <h3 class="mt-2"><?= esc($meal['strMeal']) ?></h3>
                </a>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

   

</div>
<?= $this->endSection() ?>