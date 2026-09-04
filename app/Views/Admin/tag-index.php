<?= $this->extend('layoutAdmin') ?>
<?= $this->section('title') ?>
<title>Admin tags</title>
<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/categories/admin-cat-index.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<div class="container-fluid">
    <h1>Les Tags</h1>

    <button type="button" class="btn btn-success mb-3"
        data-bs-toggle="modal"
        data-bs-target="#addModal">
        Ajouter un tag
    </button>
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>NOM</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tags as $tag): ?>
                <tr>
                    <td><?= esc($tag->name) ?></td>
                    <td><img src="<?= base_url(esc($tag->image_url, 'attr')) ?>" alt="Illustration du tag" style="max-height:40px;"></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-blue"
                            data-bs-toggle="modal"
                            data-bs-target="#updateModal<?= $tag->id ?>">
                            Modifier
                        </button>

                        <form action="<?= base_url('Admin/tag-delete/' . $tag->id) ?>" method="post" style="display:inline;">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-coral"
                                onclick="return confirm('Supprimer ce tag ?');">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('Admin/category-add') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Nom">
                    <input type="text" name="image_url" class="form-control" placeholder="Chemin de l'image">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($tags as $tag): ?>
    <div class="modal fade" id="updateModal<?= $tag->id ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url('Admin/tag-update/' . $tag->id) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier le tag</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control mb-2" value="<?= esc($tag->name) ?>">
                        <input type="text" name="image_url" class="form-control" value="<?= esc($tag->image_url) ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection() ?>