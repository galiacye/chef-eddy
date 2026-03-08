<?= $this->extend('layout') ?>

<?= $this->section('custom-css') ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<h1 class="text-center">Proposez une recette</h1>

<?= form_open_multipart('add-recipe', ['id' => 'form']) ?>

    <label for="titre">Titre</label>
    <?= form_input(['name' => 'titre', 'id' => 'titre', 'value' => set_value('titre'), 'class' => 'form-control w-50']) ?>
    <?= validation_show_error('titre') ?>

    <label for="image_url">Illustration</label>
    <?= form_upload(['name' => 'image_url', 'id' => 'image_url', 'class' => 'form-control w-50']) ?>
    <?= validation_show_error('image_url') ?>

    <label for="temps_preparation">Temps de préparation (minutes)</label>
    <?= form_input(['name' => 'temps_preparation', 'id' => 'temps_preparation', 'type' => 'number', 'value' => set_value('temps_preparation'), 'class' => 'form-control w-50']) ?>
    <?= validation_show_error('temps_preparation') ?>

    <label for="temps_cuisson">Temps de cuisson (minutes)</label>
    <?= form_input(['name' => 'temps_cuisson', 'id' => 'temps_cuisson', 'type' => 'number', 'value' => set_value('temps_cuisson'), 'class' => 'form-control w-50']) ?>
    <?= validation_show_error('temps_cuisson') ?>

    <label for="nb_personnes">Nombre de personnes</label>
    <?= form_input(['name' => 'nb_personnes', 'id' => 'nb_personnes', 'type' => 'number', 'value' => set_value('nb_personnes'), 'class' => 'form-control w-50']) ?>
    <?= validation_show_error('nb_personnes') ?>

    <label for="difficulte">Difficulté</label>
    <?= form_dropdown('difficulte', ['facile' => 'Facile', 'moyen' => 'Moyen', 'difficile' => 'Difficile'], set_value('difficulte'), ['id' => 'difficulte', 'class' => 'form-select w-50']) ?>
    <?= validation_show_error('difficulte') ?>

    <label>La Recette</label>
    <!-- Toolbar Quill -->
    <div id="toolbar">
        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-underline"></button>
        <button class="ql-list" value="ordered"></button>
        <button class="ql-list" value="bullet"></button>
    </div>
    <!-- Éditeur Quill -->
    <div id="editor" style="height: 300px; border: 1px solid #ccc;"></div>
    <!-- Champ caché qui reçoit le HTML de Quill avant submit -->
    <input type="hidden" name="contenu" id="contenu" value="<?= set_value('contenu') ?>">
    <?= validation_show_error('contenu') ?>

    <button type="submit" class="btn btn-primary mt-3">Envoyer</button>

<?= form_close() ?>

<?= $this->endSection() ?>

<?= $this->section('custom-js') ?>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    const quill = new Quill('#editor', {
        modules: { toolbar: '#toolbar' },
        placeholder: 'Écrivez votre recette ici...',
        theme: 'snow',
    });

    // Tooltips FR
    document.querySelector('.ql-bold').setAttribute('title', 'Gras');
    document.querySelector('.ql-italic').setAttribute('title', 'Italique');
    document.querySelector('.ql-underline').setAttribute('title', 'Souligné');
    document.querySelector('.ql-list[value="ordered"]').setAttribute('title', 'Liste numérotée');
    document.querySelector('.ql-list[value="bullet"]').setAttribute('title', 'Liste à puces');

    // Récupérer le contenu existant si retour de validation
    const existingContent = document.getElementById('contenu').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Injecter le HTML Quill dans le champ caché au submit
    document.getElementById('form').addEventListener('submit', (e) => {
        const html = quill.root.innerHTML;
        const text = quill.getText().trim();
        if (text.length === 0) {
            e.preventDefault();
            alert('Veuillez écrire votre recette avant d\'envoyer');
            return;
        }
        document.getElementById('contenu').value = html;
    });
</script>
<?= $this->endSection() ?>