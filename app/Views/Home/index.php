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

</div>
<?= form_close() ?>

<div class="row mt-4">
    <div class="col-sm-12 md-4 lg-3">
        <h2>Recettes de Chef Eddy</h2>
        <div class="row">
            <?php foreach ($Recipes as $recipe) : ?>
                <div class="col-10 col-md-6 col-lg-4  mb-4">
                    <div class="card h-100">
                       <img src="<?= base_url($recipe->image_url ? $recipe->image_url : 'uploads/recipes/default.png') ?>" 
                                    class="card-img-top" alt="<?= esc($recipe->titre) ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= esc($recipe->titre) ?></h5>
                            
                            <a href="<?= base_url('recipe/' . $recipe->id) ?>" class="btn btn-primary mt-auto">Voir la recette</a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
                
<?= $this->endSection() ?>