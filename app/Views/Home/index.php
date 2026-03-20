<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<!-- <div class="row">
    <div class="col-auto">
        <button class="btn btn-primary">Déjà membre</button>
    </div>
    <div class="col-2">
        <p> OU </p>
    </div>
    <div class="col-auto">
        <button class="btn btn-primary">S'inscrire</button>
    </div>
</div> -->
    
        <br>
  
    <?= form_open('search',['method'=>'GET'])?>
      <div class="row d-flex align-items-center">
        <div class="col-auto">
            <input type="text" name="search" class="form-control" placeholder="Rechercher une recette">
        </div>
        <div class="col-auto">
            <button type="submit"class="btn btn-primary">search</button>
        </div>
        <div class="col-auto">  OU  </div>
        <div class="col-auto">
            <label for="ingredients_input">Rechercher une recette par ingrédient</label>
             <!-- input list pointe vers datalist id , name="ingredient" au sing cf Controller -->
            <input list="ingredients-list" id="ingredients_input" name="ingredient" placeholder="entrez ici le nom d'un ingrédient pour accéder aux recettes qui le contiennent">
                <datalist id="ingredients-list">
                <?php foreach($ingredients as $ingr) : ?>
                    <option value="<?= esc($ingr->nom)?>"></option>
                <?php endforeach ?>
                </datalist>
        </div>
        <div class="col-auto">
            <button type="submit"class="btn btn-primary">Search...</button>
        </div>
      </div>
    <?= form_close() ?>
<?= $this->endSection() ?>

