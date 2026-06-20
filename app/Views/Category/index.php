<?= $this->extend('layout') ?>
<?= $this->section('meta_description') ?>
Catégories de recettes sur Chef Eddy
<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="<?= base_url('./css/categories/cat-index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<h2 class="text-center m-4">Les catégories</h2>
<div class="container">
    <div class="nav-grid">
        <?php foreach ($categories as $category) : ?>
            <a href="<?= base_url('category/' . $category->id) ?>" class="nav-card">
                <img src="<?= base_url($category->image_url ?? 'img/categories/default.avif') ?>"
                     class="nav-icon" alt="<?= esc($category->name) ?>">
                <span class="nav-title"><?= esc($category->name) ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>

