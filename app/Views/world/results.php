<?= $this->extend('layout') ?>

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
      <!-- cas où l'API ne retourne aucune recette pour ce pays  -->
        <p>Aucune recette trouvée.</p>
    <?php else: ?>
       <!-- grille de recettes, chaque carte pointe vers le détail -->
        <div class="recipes-grid">
            <?php foreach ($meals as $meal): ?>
                <a href="<?= site_url('cuisine-du-monde/recette/' . (int)$meal['idMeal']) ?>" class="recipe-card">
                    <img src="<?= esc($meal['strMealThumb']) ?>" alt="<?= esc($meal['strMeal']) ?>">
                    <h3><?= esc($meal['strMeal']) ?></h3>
                </a>
            <?php endforeach ?>
        </div>
    <?php endif ?>

    <a href="<?= site_url('cuisine-du-monde') ?>" class="btn-action">
   Retour en cuisine
    </a>

</div>
<?= $this->endSection() ?>