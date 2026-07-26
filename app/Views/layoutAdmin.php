<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow"><!--referencement inutile pour pages admin-->
    <title>Admin - <?= $this->renderSection('titre') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Syncopate:wght@400;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Elms+Sans:ital,wght@0,100..900;1,100..900&family=Syncopate:wght@400;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('css/layoutAdmin.css') ?>" rel="stylesheet">
    <?= $this->renderSection('custom-css') ?>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark navbar-expand-md"><!--expand: déplie le burger à partir de md-->
        <div class="container-fluid">

            <a class="navbar-brand" href="/Admin">
                <img src="<?= base_url('img/Home/eddy-bd.jpeg') ?>" height="80" alt="Chef Eddy" class="eddy">
            </a>
            <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <span class="navbar-brand">Chef Eddy Administration</span>
                <div>
                    <?php if (uri_string() != 'dashboard'): ?><!--current renvoie l'url complète )-->
                        <a href="/dashboard" class="btn btn-outline-light btn-sm me-2">Tableau de bord</a>
                    <?php endif; ?>

                    <?php if (uri_string() != 'Admin/recipes-index'): ?>
                        <a href="/Admin/recipes-index" class="btn btn-outline-light btn-sm me-2">Recettes</a>
                    <?php endif; ?>

                    <?php if (uri_string() != 'Admin/users-index'): ?>
                        <a href="/Admin/users-index" class="btn btn-outline-light btn-sm me-2">Utilisateurs</a>
                    <?php endif; ?>

                    <?php if (uri_string() != 'Admin/comments'): ?>
                        <a href="/Admin/comments" class="btn btn-outline-light btn-sm me-2">Commentaires</a>
                    <?php endif; ?>

                    <a href="/" class="btn btn-emeraude btn-sm">Site</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container-fluid px-0">
        <?= $this->renderSection('body') ?>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('customJs') ?>
</body>

</html>