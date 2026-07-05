<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <!--pour afficher sur tablette et mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--pour améliorer le référencement-->
    <meta name="description" content="<?= $this->renderSection('meta_description') ?>">
    <?= $this->renderSection('description') ?>
    <?= $this->renderSection('title') ?>
    <!-- lien vers le framework CSS Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- lien vers la bibliothèque d'icônes Bootstrap Icons 1.11.1 -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- liens vers les polices Google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Syncopate:wght@400;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Elms+Sans:ital,wght@0,100..900;1,100..900&family=Syncopate:wght@400;700&display=swap" rel="stylesheet">
    <!--feuille de style-->
    <link href="<?= base_url('css/layout.css') ?>" rel="stylesheet">
    <!--section CI4-->
    <?= $this->renderSection('custom-css') ?>
</head>


<body>


    <header class="py-3">
        <div class="ban d-flex align-items-center pe-3">

            <div class="title ps-3">
                <h1 class="chef-title">Chef Eddy</h1>
            </div>

            <div class="logo">
                <img src="<?= base_url('img/logo-chef-transp.png') ?>" class="logo" alt="logo">
            </div>

        </div>
    </header>


    <nav class="navbar navbar-expand-lg navbar-custom">
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
                    <!-- //uri_string mieux que current_url() qui retourne url complète -->
                    <!-- current_url() != base_url() -->
                    <?php if (uri_string() != '') : ?>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="<?= base_url('tag/index') ?>">
                                Tags
                            </a>
                        </li>
                    <?php endif; ?>


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
                                href="<?= base_url('favorites') ?>">
                                Mes favorites
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

    <main class="container-fluid px-2 w-100">

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>


        <?= $this->renderSection('body') ?>
    </main>
    <footer class="mt-5">
        
            <p class="text-center">&copy; <?= date('Y') ?> Chef Eddy</p>
            <a href="<?= site_url('mentions-legales') ?>" class="text-center">Mentions légales</a>
    
    </footer>
    <?= $this->renderSection('customJs') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>