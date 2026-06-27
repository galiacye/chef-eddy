<?= $this->extend('layout') ?>
<?= $this->section('meta_description') ?>Tags sur Chef Eddy<?= $this->endSection() ?>

<?= $this->section('title') ?><titre>Tous les Tags</titre><?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/categories/cat-index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>



<?= $this->section('body') ?>
<h2 class="text-center m-4">Les Tags</h2>
<div class="container">
    <div class="nav-grid">
        <?php foreach ($tags as $tag) : ?>
            <a href="<?= base_url('tag/show/' . $tag->id) ?>" class="nav-card">
                <img src="<?= base_url($tag->image_url ?? 'img/categories/default.avif') ?>"
                     class="nav-icon" alt="<?= esc($tag->name) ?>">
                <span class="nav-title"><?= esc($tag->name) ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?= $this->endSection() ?>

