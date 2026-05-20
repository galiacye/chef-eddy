<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= $this->renderSection('title') ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  
    <link href="<?= base_url('./css/layout.css') ?>" rel="stylesheet">

    <?= $this->renderSection('custom-css') ?>
</head>

<body>

  
    <header class="py-3">
        <div class="ban">
            <div class="container text-center">
                <h1 class="hero-title">Chef Eddy</h1>
            </div>
        </div>
    </header>

  
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            <!-- Btn burger-->
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNavbar"
                    aria-controls="mainNavbar"
                    aria-expanded="false"
                    aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <!-- navbar content -->
            <div class="collapse navbar-collapse" id="mainNavbar">

                <!-- gauche -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?= base_url('index.php') ?>">
                            Accueil
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?= base_url('recipe-index') ?>">
                            Toutes les recettes
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?= base_url('category/index') ?>">
                            Les catégories
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?= base_url('tag/index') ?>">
                            Tags
                        </a>
                    </li>

                    <?php if (session()->get('role_id') >= 2): ?>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?= base_url('add-recipe') ?>">
                                Proposer une recette
                            </a>
                        </li>

                    <?php else: ?>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?= base_url('register') ?>">
                                Proposer une recette
                            </a>
                        </li>

                    <?php endif ?>

                </ul>

                <!-- droite -->
                <ul class="navbar-nav">

                    <?php if (session()->has('user_id')): ?>

                        <?php if (session()->get('role_id') == 3): ?>

                            <li class="nav-item">
                                <a href="<?= base_url('/dashboard') ?>"
                                   class="nav-link">
                                    Admin
                                </a>
                            </li>

                        <?php endif ?>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?= base_url('profile') ?>">
                                Mon Profil
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?= base_url('mes-recettes') ?>">
                                Mes recettes
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?= base_url('logout') ?>">
                                Se déconnecter
                            </a>
                        </li>

                    <?php else: ?>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?= base_url('login') ?>">
                                Déjà membre
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                               href="<?= base_url('register') ?>">
                                S'inscrire
                            </a>
                        </li>

                    <?php endif; ?>

                </ul>

            </div>
        </div>
    </nav>

    <!-- main content -->
    <main class="container-fluid px-1 w-100">
        <?= $this->renderSection('body') ?>
    </main>

    <?= $this->renderSection('custom-js') ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>