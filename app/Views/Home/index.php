<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<?= form_open('search', ['method' => 'GET']) ?>
<div class="row d-flex align-items-center">

    <div class="col-auto">
        <input type="text" name="search" id="search_input"
            class="form-control" placeholder="Rechercher une recette">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </div>

    <div class="col-auto">OU</div>

    <div class="col-auto">
        <input list="ingredients-list" id="ingredients_input"
            name="ingredient" class="form-control"
            placeholder="Recettes par ingrédient">
        <datalist id="ingredients-list">
            <?php foreach ($ingredients as $ingr) : ?>
                <option value="<?= esc($ingr->nom) ?>"></option>
            <?php endforeach ?>
        </datalist>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </div>

    <div class="col-auto">OU SANS </div>

    <div class="col-auto">
        <select name="without" class="form-select">
            <option value="">-- Sans restriction --</option>
            <?php foreach ($categories as $cat) : ?>
                <option value="<?= esc($cat->nom) ?>"><?= esc($cat->nom) ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Rechercher</button>
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

        <div class="row mt-4">

            <div class="col-2">
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