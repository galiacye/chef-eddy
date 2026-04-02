<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->renderSection('title') ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('./css/header-mq.css') ?>" rel="stylesheet">
    <?= $this->renderSection('custom-css') ?>
</head>

<body>

   <header class="bg-dark text-light py-3">
    <div class="ban ">
        <img src="<?= base_url('./img/eddy-bd.jpeg') ?>" class="eddy">
        <div class="container text-center">
            <h1 class="hero-title">Chef Eddy</h1>
            <h2 class="txt">On ne rigole pas avec les grammages...</h2>
        </div>
        <img src="<?= base_url('./img/logo.png') ?>" alt="logo" class="logo">

    </div>
</header>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('users') ?>">Utilisateurs</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('recipeIndex') ?>">Toutes les recettes</a>
            </li>
            <li>
                <a class="nav-link" href="<?= base_url('categories') ?>"> Les Catégories</a>
            </li>
            <li>
                <a class="nav-link" href="<?= base_url('tags') ?>">Tags</a>
            </li>
            <li>
                <a class="nav-link" href="<?= base_url('ingredients') ?>">Recherche par ingrédients</a>
            </li>
        </ul>
    </div>
</nav>

    <main class="container mt-4">
        <?= $this->renderSection('body') ?>
    </main>

    <?= $this->renderSection('custom-js') ?>

    

</body>
</html>
