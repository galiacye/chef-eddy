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

   <header class="bg-dark text-light py-3"> <!-- py = top+bottom -->
    <div class="ban ">
        <img src="<?= base_url('./img/eddy-bd.jpeg') ?>" class="eddy">
        <div class="container text-center">
            <h1 class="hero-title">Chef Eddy  </h1>
            <h2 class="txt">On ne rigole pas avec les grammages...</h2>
        </div>
        <img src="<?= base_url('./img/logo.png') ?>" alt="logo" class="logo">

    </div>
</header>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">  <!-- expand-lg =>se replie en deçà de 1024 -->
   
    <div class="container d-flex justify-content-between">
        <div class="left">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('index.php') ?>">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('recipeIndex') ?>">Toutes les recettes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('categorie/index') ?>"> Les Catégories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('tag/index') ?>">Tags</a>
            </li>
            <li>
                <a class="nav-link" href="<?= base_url('/edit-recipe') ?>">Proposez une recette</a>
                <!--enverra sur s'inscrire-->
            </li>
        </ul>
        </div>
        <div class="right">
        <ul class="navbar-nav">
            <?php if(session()->has('user_id')): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('profile') ?>">Mon Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('mes-recettes') ?>">Mes Recettes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('logout') ?>">Se Déconnecter</a>
                </li>
        </ul>
            <?php else: ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('Admin/login') ?>">Déjà membre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('User/register') ?>">S'inscrire</a>
                    </li>
                </ul>
            <?php endif; ?>
    </div>
</nav>

    <main class="container mt-4">
        <?= $this->renderSection('body') ?>
    </main>

    <?= $this->renderSection('custom-js') ?>

    

</body>
</html>
