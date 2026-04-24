<?= $this->extend('layout') ?>
<?= $this->section('body') ?>

<?=  $this->section('custom-js')?>
    <!-- Dans le <head> : chargement de Quill -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="quill-update.js"></script>
<?= $this->endSection() ?>


<!-- Dans le <body> : le formulaire -->
<form method="POST" action="traitement.php">

  <!-- L'éditeur visible par l'utilisateur -->
  <div id="editor"></div>

  <!-- Le champ caché : pont entre Quill et PHP -->
  <input type="hidden" id="contenu" name="contenu" value="<?= $recette ?? '' ?>">
  <!--  PHP met la valeur existante ici si on est en mode modification -->

  <button type="submit">Envoyer</button>

</form>