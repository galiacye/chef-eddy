<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?= $this->renderSection('metadescription') ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <?= $this->renderSection('customcss') ?>
    <link href="<?= base_url('assets/css/layout.css') ?>" rel="stylesheet">
  

    <title><?= $this->renderSection('title') ?></title>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- HEADER FULL WIDTH -->
    <!-- header id pour scrip js cas sticky -->
    <header id="mainHeader" class="border-bottom shadow vert w-100">
        <div class="container-fluid py-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                <!-- LOGO -->
                <a href="/">
                    <img src="<?= base_url('assets/img/logo_text.png') ?>"
                        alt="ToyCycle Logo"
                        style="height: 120px;">
                </a>

                <!-- NAV -->
                <nav class="d-flex gap-3 flex-wrap justify-content-center">
                    <a href="<?= base_url('backdoor/toys/1') ?>" class="btn btn-custom">Jouets</a>
                    <a href="<?= base_url('backdoor/admin/users') ?>" class="btn btn-custom">Utilisateurs</a>
                    <a href="<?= base_url('backdoor/orders') ?>" class="btn btn-custom">Commandes</a>
                    <a href="<?= base_url('backdoor/comments') ?>" class="btn btn-custom">Commentaires</a>
                </nav>

                <div class="d-flex gap-3 align-items-center">
                    <a href="<?= base_url('backdoor/admin') ?>" class="btn btn-dashboard" style="background-color: orange;">Tableau de bord</a>
                   
                   
                </div>

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
