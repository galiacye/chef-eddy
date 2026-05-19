<?= $this->extend('layoutFront') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<?= form_open('search', ['method' => 'GET']) ?>
<div class="row d-flex align-items-center">

    <div class="search-scroll">

        <div class="search-box position-relative">
            <div class="input-group">
                <input type="text" class="form-control pe-5" placeholder="Rechercher une recette">

                <button type="submit"
                    class="btn position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>


        <div class="search-box position-relative">


            <div class="col-auto  d-flex">


                <input list="ingredients-list" id="ingredients_input"
                    name="ingredient" class="form-control"
                    placeholder="Avec...">
                <datalist id="ingredients-list">
                    <?php foreach ($ingredients as $ingr) : ?>
                        <option value="<?= esc($ingr->nom) ?>"></option>
                    <?php endforeach ?>
                </datalist>
            </div>

            <div class="col-auto d-flex">
                <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent">
                     <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        <div class="search-box position-relative">


            <div class="col-auto d-flex">
                <select name="without" class="form-select">
                    <option value=""> Sans... </option>
                    <?php foreach ($categories as $cat) : ?>
                        <option value="<?= esc($cat->nom) ?>"><?= esc($cat->nom) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="col-auto d-none d-md-flex">
                <button type="submit" class="btn position-absolute top-50 end-0 translate-middle-y me-2 border-0 bg-transparent">
                  
            </button>
            </div>
        </div>
    </div>
   
</div>

<?= form_close() ?>

<div class="row mt-4 w-100">
    <div class="col-12">
        <div class="row one justify-content-between align-items-center">

            <div class="col-2">
                <img src="<?= base_url('./img/logo.png') ?>" alt="logo" class="logo">
            </div>

            <div class="col-8 text-center">
                <h1>Les recettes du Chef Eddy</h1>
                <h2 class="txt">On ne rigole pas avec les grammages...</h2>
            </div>

            <div class="col-2 ">
                <img src="./img/eddy-bd.jpeg" class="eddy">
            </div>
        </div>

        <button class="btn btn-primary d-md-none mb-3"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#tagsCollapse"
            aria-expanded="false"
            id="tagsBtn">
            <i class="bi bi-list fs-4" id="tagsIcon" style="font-style: normal;">Tags</i>
        </button>


        <div class="row mt-4">

            <div class="col-2">

                <div class="collapse d-md-block" id="tagsCollapse">
                    <div class="row tags">
                        <div class="col-12">
                            <h2 class="text-center">Tags</h2>

                            <?php foreach ($tags as $tag) : ?>

                                <div class="d-flex justify-content-center align-items-center mb-4">
                                    <a href="<?= site_url('tag/' . $tag->id) ?>"
                                        class="btn btn-tag">
                                        <?= esc($tag->nom) ?>
                                    </a>
                                </div>

                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-10">
                <div class="row">

                    <?php foreach ($Recipes as $recipe) : ?>

                        <div class="col-10 col-md-6 col-lg-4 mb-4">
                            <div class="card w-custom ">
                                <div class="img-wrapper">
                                    <img src="<?= base_url($recipe->image_url ? $recipe->image_url : 'uploads/recipes/default.png') ?>"
                                        class="card-img-top" alt="<?= esc($recipe->titre) ?>">
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= esc($recipe->titre) ?></h5>

                                    <a href="<?= base_url('recipe/' . $recipe->id) ?>" class="btn btn-see mt-auto">Voir</a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

<?= $this->endSection() ?>
<?= $this->section('custom-js') ?>
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