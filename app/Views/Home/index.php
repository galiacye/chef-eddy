<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="row">
    <div class="col-auto">
        <button class="btn btn-primary">Déjà membre</button>
    </div>
    <div class="col-2">
        <p> OU </p>
    </div>
    <div class="col-auto">
        <button class="btn btn-primary">S'inscrire</button>
    </div>
</div>
    
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
             <!-- input list pointe vers datalist id , name="ingredient" au sing cf Controller -->
            <input list="ingredients-list" id="ingredients_input" 
                name="ingredient" 
                placeholder="Recettes par ingrédients"
                class="form-control">
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
    <div class="row d-flex align-items-center divers">
        <div class="col md-4 lg-2 cat">
            <img src="<?= base_url('img/desserts/cheesecake-speculoos.jpg') ?>" class="photo1">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Sed aut repellendus debitis doloremque omnis esse, voluptate ad nesciunt 
                deserunt exercitationem. Odio velit veniam facere. Libero perferendis 
                officia doloribus ipsam repudiandae.

            </p>
        </div>
        <div class="col md-4 lg-2 tags">
              <img src="<?= base_url('img/desserts/cheesecake-speculoos.jpg') ?>" class="photo1">      
                     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Sed aut repellendus debitis doloremque omnis esse, voluptate ad nesciunt 
                deserunt exercitationem. Odio velit veniam facere. Libero perferendis 
                officia doloribus ipsam repudiandae.

            </p>
            </div>
        <div class="col md-4 lg-2 saison">
            <img src="<?= base_url('img/desserts/cheesecake-speculoos.jpg') ?>" class="photo1">

                     <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                Sed aut repellendus debitis doloremque omnis esse, voluptate ad nesciunt 
                deserunt exercitationem. Odio velit veniam facere. Libero perferendis 
                officia doloribus ipsam repudiandae.

            </p>
        </div>
    </div>
<?= $this->endSection() ?>

