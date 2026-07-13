<?= $this->extend('layout') ?>
<?= $this->section('title') ?>
<title>Accueil Chef Eddy</title>
<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<div class="container-fluid px-0">

    <?= form_open('search', ['method' => 'GET']) ?>
    <div class="d-flex justify-content-center mt-3">
        <div class="search-wrapper">


            <div class="search-box1 d-flex align-items-center gap-1 mb-2 mt-2">
                <input type="text"
                    name="search"
                    class="form-control shadow flex-grow-1 mw-0"
                    placeholder="Taper le nom d'une recette ou d'un ingrédient">
            </div>

            <div class="d-flex justify-content-center mb-2">
                <button type="button" class="btn btn-sm btn-secondary shadow"
                    data-bs-toggle="collapse" data-bs-target="#filtres">
                    Filtres
                </button>
            </div>

            <div class="collapse" id="filtres">
                <p class="text-muted mb-2 mt-2 text-center">Exclure :</p>
                <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                    <?php foreach ($categories as $cat): ?>
                        <input class="allergen-check shadow"
                            type="checkbox"
                            name="without[]"
                            value="<?= esc($cat->name) ?>"
                            id="cat_<?= esc($cat->name) ?>">
                        <label class="allergen-label" for="cat_<?= esc($cat->name) ?>">
                            <?= esc($cat->name) ?>
                        </label>
                    <?php endforeach ?>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-search w-100 shadow">
                    <i class="bi bi-search"></i> Lancer la recherche
                </button>
            </div>

        </div>
    </div>
    <?= form_close() ?>

    <div class="row mt-4 w-100 mx-0">

        <!-- colonne de gauche : tags -->
        <div class="col-md-2">
            <button class="btn btn-info d-md-none mb-3"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#tagsCollapse"
                aria-expanded="false"
                id="tagsBtn">
                <i class="bi bi-list fs-4"
                    id="tagsIcon"
                    style="font-style: normal; font-family: 'nexa';">
                    Tags
                </i>
            </button>

            <div class="collapse d-md-block" id="tagsCollapse">
                <div class="row tags">
                    <div class="col-12">
                        <h2 class="tag-title text-center mb-4">Tags</h2>
                        <?php foreach ($tags as $tag) : ?>
                            <div class="d-flex justify-content-center align-items-center mb-4">
                                <?php if ($tag->name === 'World Food') : ?>
                                    <a href="<?= site_url('cuisine-du-monde') ?>" class="btn btn-tag">
                                        <?= esc($tag->name) ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?= site_url('tag/show/' . $tag->id) ?>" class="btn btn-tag">
                                        <?= esc($tag->name) ?>
                                    </a>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="row chef-recipes">
                <?php foreach ($recipes as $recipe) : ?>
                    <div class="col-12 col-md-4 col-lg-3 mb-4 d-flex justify-content-center">
                        <div class="card w-custom mt-4">
                            <div class="img-wrapper">
                                <img src="<?= base_url($recipe->image_url ? $recipe->image_url : 'uploads/recipes/default.png') ?>"
                                    class="card-img-top"
                                    alt="<?= esc($recipe->title) ?>">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <?= esc($recipe->title) ?>
                                </h5>
                                <a href="<?= base_url('recipe/' . (int)$recipe->id) ?>"
                                    class="btn btn-see mt-auto">
                                    Voir
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('customJs') ?>
<script>
    const collapse = document.getElementById('tagsCollapse');
    const icon = document.getElementById('tagsIcon');

    collapse.addEventListener('show.bs.collapse', function() {
        icon.classList.remove('bi-list');
        icon.classList.add('bi-x-lg');
    });

    collapse.addEventListener('hide.bs.collapse', function() {
        icon.classList.remove('bi-x-lg');
        icon.classList.add('bi-list');
    });
</script>

<?= $this->endSection() ?>