<?= $this->extend('layout') ?>

<?= $this->section('meta_description') ?>
Résultats pour "Cuisine de <?= esc($country) ?>" sur Chef Eddy
<?= $this->endSection() ?>

<?= $this->section('title') ?>
<title>Cuisine <?= esc($country) ?></title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/recipes/crecipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container">

    <h1>Cuisine <?= esc($country) ?></h1>

    <?php if (empty($meals)): ?>
      <!-- cas où api ne retourne aucune recette pour ce pays  -->
        <p>Aucune recette trouvée.</p>
    <?php else: ?>
       <!-- grille de recettes, cards en boucle -->
        <div class="recipes-grid">
            <?php foreach ($meals as $meal): ?>
                <a href="<?= site_url('cuisine-du-monde/recette/' . (int)$meal['idMeal']) ?>" class="recipe-card">
<!--url img api-->  <img src="<?= esc($meal['strMealThumb']) ?>" alt="<?= esc($meal['strMeal']) ?>">
<!--str pour string en json-->
                    <h3><?= esc($meal['strMeal']) ?></h3>
                </a>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <a href="<?= site_url('cuisine-du-monde') ?>" class="btn-action">
   Retour à la liste des pays
    </a>

</div>
<?= $this->endSection() ?>