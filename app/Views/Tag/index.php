<?= $this->extend('layout') ?>
<?= $this->section('body') ?>

<h2 class="text-center">Les tags</h2>
<div class="container">
    <div class="row">
        <?php foreach ($tags as $tag) : ?>
            <div class="col-auto mb-2">
                <a href="<?= site_url('tag/' . $tag->id) ?>" 
                   class="btn btn-outline-primary">
                    <?= esc($tag->nom) ?>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?= $this->endSection() ?>