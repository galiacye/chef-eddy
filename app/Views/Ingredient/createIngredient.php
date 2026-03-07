<form method="post" enctype="multipart/form-data">
<!-- enctype obligatoire pour pdf ou images -->
    <input type="text" name="nom" placeholder="Nom de l'ingrédient">

    <input type="file" name="image_url" accept="image/jpg, image/jpeg, image/png">

    <?php foreach ($categories as $categorie): ?>
        <label>
            <input type="radio" name="categorie_id" value="<?= $categorie->id ?>">
            <?= $categorie->nom ?>
        </label>
    <?php endforeach ?>

    <button type="submit">Créer</button>

</form>