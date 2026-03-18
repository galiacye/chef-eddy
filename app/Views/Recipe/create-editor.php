<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="<?= base_url('css/editor.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<?= form_open('create-editor', ['id' => 'form']) ?>

<label for="contenu"><h2>Votre Recette</h2></label>
<div id="toolbar">
    <button class="ql-bold"></button>
    <button class="ql-italic"></button>
    <button class="ql-underline"></button>
    <button class="ql-list" value="ordered"></button>
    <button class="ql-list" value="bullet"></button>
</div>
<div id="editor"></div>
<input type="hidden" name="contenu" id="contenu" value="<?= set_value('contenu') ?>">

<button type="submit" class="btn btn-primary">Envoyer</button>
<?= form_close() ?>

<?= $this->section('custom-js') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    const quill = new Quill('#editor', {
        modules: { //relie la toolbar qui est en dehors du form
            toolbar: '#toolbar'
        },
        placeholder: 'Écrivez votre recette ici...',
        theme: 'snow',
    });
    const existingContent = document.getElementById('contenu').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Ajouter les tooltips en français
    document.querySelector('.ql-bold').setAttribute('title', 'Gras');
    document.querySelector('.ql-italic').setAttribute('title', 'Italique');
    document.querySelector('.ql-underline').setAttribute('title', 'Souligné');
    document.querySelector('.ql-list[value="ordered"]').setAttribute('title', 'Liste numérotée');
    document.querySelector('.ql-list[value="bullet"]').setAttribute('title', 'Liste à puces');

   


    // Gestion de la soumission du formulaire
    document.getElementById('form').addEventListener('submit', (e) => {
        const html = quill.root.innerHTML;
        document.getElementById('contenu').value = html;

        // Vérifier que ce n'est pas vide
        const text = quill.getText().trim();
        if (text.length === 0) {
            e.preventDefault(); //empêche l'envoi par défaut
            alert('Veuillez écrire une recette avant d\'envoyer');
        }
    });
</script>

<?= $this->endSection() ?>

<?= $this->endSection() ?>

