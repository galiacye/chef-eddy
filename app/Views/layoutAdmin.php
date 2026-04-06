<!-- app/Views/layouts/admin.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?= $this->renderSection('titre') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?= $this->renderSection('custom-css') ?>
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark" style="height: 100px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/admin">
            <img src="<?= base_url('img/eddy-bd.jpeg') ?>" height="80" alt="Chef Eddy">
            </a>
            <span class="navbar-brand"> Admin Chef Eddy</span>
            <div>
                <a href="/Admin/recipeIndex" class="btn btn-outline-light btn-sm me-2">Recettes</a>
                <a href="/Admin/userIndex" class="btn btn-outline-light btn-sm me-2">Utilisateurs</a>
                <a href="/" class="btn btn-outline-warning btn-sm">Site</a>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <?= $this->renderSection('body') ?>
    </main>

</body>
</html>