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

    <header class="text-light py-3"> <!-- py = top+bottom -->
        <div class="ban ">
           
            <div class="container text-center">
                <h1 class="hero-title">Chef Eddy </h1>
                
            </div>
           

        </div>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4"> <!-- expand-lg =>se replie en deçà de 1024 -->






    
        <!--
            <button class="navbar-toggler d-lg-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#cupcake">
                <i class="bi bi-list"></i>
            </button>


            <div class="collapse d-lg-flex header-center" id="headerCenter">

                <nav class="header-nav">
                    <a href="<?= base_url('store/toy/category/figurines') ?>" class="btn btn-custom">Figurines</a>

                    <a href="<?= base_url('store/toy/category/jouetenbois') ?>" class="btn btn-custom">
                        Jouets en bois
                    </a>

                    <a href="<?= base_url('store/toy/category/jeudesociete') ?>" class="btn btn-custom">
                        Jeux de société
                    </a>

                    <a href="<?= base_url('store/toy/category/vehicules') ?>" class="btn btn-custom">
                        Véhicules
                    </a>
                </nav>

                
                <form method="GET"
                    action="<?= base_url('store/toy/search') ?>"
                    class="search-form">

                    <input class="form-control"
                        type="search"
                        name="q"
                        placeholder="Rechercher...">

                    <button class="btn search-btn" type="submit">
                        <img src="<?= base_url('assets/img/lupe.png') ?>">
                    </button>

                </form>
            </div> -->
            
















        <div class="container d-flex justify-content-between">
            <div class="left">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('index.php') ?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('recipe-index') ?>">Toutes les recettes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('category/index') ?>"> Les Catégories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('tag/index') ?>">Tags</a>
                    </li>
                    <?php if (session()->get('role_id') >= 2): ?>
                        <li>
                            <a class="nav-link" href="<?= base_url('add-recipe') ?>">Proposer une recette</a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a class="nav-link" href="<?= base_url('register') ?>">Proposer une recette</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
            <div class="right">
                <ul class="navbar-nav">
                    <?php if (session()->has('user_id')): ?>
                        <li class="nav-item">
                            <?php if (session()->get('role_id') == 3): ?>
                                <a href="<?= base_url('/dashboard') ?>" class="nav-link btn btn-outline-info btn-sm">Admin</a>
                            <?php endif ?>
                        </li>
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
                        <a class="nav-link" href="<?= base_url('login') ?>">Déjà membre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('register') ?>">S'inscrire</a>
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