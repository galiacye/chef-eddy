<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

    <h1>TEST</h1>
    
        <button class="btn btn-primary">Déjà membre</button>
        <button class="btn btn-primary">S'inscrire</button>
  
    <?= form_open('search',['method'=>'GET'])?>
      <div class="row">
        <div class="col-md-8">
            <input type="text" name="search" class="form-control" placeholder="Rechercher une recette">
        </div>
        <div class="col-auto">
            <button type="submit"class="btn btn-primary">Rechercher</button>
        </div>
      </div> 
    <?= form_close() ?>
<?= $this->endSection() ?>

