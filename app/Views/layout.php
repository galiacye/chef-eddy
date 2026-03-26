<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->renderSection('title') ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('./css/header.css') ?>" rel="stylesheet">
    <?= $this->renderSection('custom-css') ?>
</head>

<body>

    <?= $this->include('partials/header') ?>

    <main class="container-fluid">
        <?= $this->renderSection('body') ?>
    </main>

    <?= $this->renderSection('custom-js') ?>

    

</body>
</html>
