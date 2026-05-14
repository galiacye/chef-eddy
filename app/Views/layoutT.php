<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= $this->renderSection('metadescription') ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <?= $this->renderSection('customcss') ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+GB+S:ital,wght@0,100..400;1,100..400&display=swap" rel="stylesheet">

   <link href="<?= base_url('css/layout.css') ?>" rel="stylesheet">
    <style>
      

        
    </style>

    <title><?= $this->renderSection('title') ?></title>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- HEADER FULL WIDTH -->
<header id="mainHeader" class="border-bottom shadow vert w-100">

    <div class="container-fluid header-wrapper">

        <!-- LEFT -->
        <div class="header-left">
            <img src="<?= base_url('assets/img/logo_text.png') ?>"
                 alt="ToyCycle Logo"
                 class="header-logo">
        </div>

        <!-- BURGER MOBILE -->
        <button class="navbar-toggler d-lg-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#headerCenter">
            ☰
        </button>

        <!-- CENTER -->
        <div class="collapse d-lg-flex header-center" id="headerCenter">

            <!-- NAV -->
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

            <!-- SEARCH -->
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
        </div>

        <!-- RIGHT -->
        <div class="header-right">

            <a href="<?= base_url('store') ?>">
                <img src="<?= base_url('assets/img/shop.png') ?>" class="header-icon">
            </a>

            <a href="<?= base_url('Profile/profile') ?>">
                <img src="<?= base_url('assets/img/konto.png') ?>" class="header-icon">
            </a>

            <a href="<?= base_url('store/cart') ?>">
                <img src="<?= base_url('assets/img/caddy3.png') ?>" class="header-icon">
            </a>

            <a href="<?= base_url('logout') ?>"
               class="btn btn-logout btn-secondary">
                Déconnexion
            </a>

        </div>

    </div>
</header>

    <!-- MAIN CONTENT -->
    <main class="flex-grow-1">
        <?= $this->renderSection('body') ?>
    </main>

    <!-- FOOTER FULL WIDTH -->
    <footer class="bg-dark text-light mt-auto w-100">
        <div class="container-fluid py-4 text-center">
            <!-- TEXTE -->
            <p class="mb-1">
                &copy; <?= date('Y') ?> ToyCycle
            </p>

            <small>
                Jouets reconditionnés <img src="<?= base_url('assets/img/footernoir.jpeg') ?>" style="height:30px;">
            </small>

        </div>
    </footer>
    <?= $this->renderSection('customJs') ?>
    <!-- cas sticky header: -->
    <!-- <script>
window.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('mainHeader');
    const main = document.querySelector('main');
    if(header && main){
        main.style.marginTop = header.offsetHeight + 'px';
    }
});
</script> -->
</body>
</html>
