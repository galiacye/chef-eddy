<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>

<link href="<?= base_url('./css/recipes/createRecipe.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<h3>Index des ingredients</h3>
<table class="table table-dark">
    <th>Tous les ingredients</th>
    <?php foreach($ingredients as $i):?>
        <td><?= $i->nom ?></td>
    <?php endforeach;?>
       
</table>