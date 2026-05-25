<?php

/**
 * @var object $status
 */
?>
<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Tous les commentaires<?= $this->endSection() ?>
<?= $this->section('custom-css') ?>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<link href="<?= base_url('css/comments.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif ?>

<h2 class="text-center mb-4">Tous les commentaires</h2>

<div class="btn-group mb-3">
    <a href="<?= base_url('Admin/comments') ?>"
        class="btn <?= $status === null ? 'btn-dark' : 'btn-outline-dark' ?>">Tous</a>
    <a href="<?= base_url('Admin/comments?status=pending') ?>"
        class="btn <?= $status === 'pending' ? 'btn-warning' : 'btn-outline-warning' ?>">En attente</a>
    <a href="<?= base_url('Admin/comments?status=approved') ?>"
        class="btn <?= $status === 'approved' ? 'btn-success' : 'btn-outline-success' ?>">Approuvés</a>
</div>

<table class="table table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>Auteur</th>
            <th>Recette</th>
            <th>Commentaire</th>
            <th>Note</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $c): ?>
                <tr> <!--user_id et username appartiennent à $c grâce à la jointure-->
                    <td><a href="<?= base_url('user/profile/' . $c->user_id) ?>"><?= $c->username ?></a></td>
                    <td><?= $c->recipe_title ?></td>
                    <td><?= $c->content ?></td>
                    <td><?= $c->rating ?>/5</td>
                    <td>
                        <span class="badge <?= $c->status === 'approved' ? 'bg-success' : ($c->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') ?>">
                            <?= $c->status ?>
                        </span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            <form method="post" action="<?= base_url('comment/status/' . $c->id . '/approved') ?>" class="d-inline">
                                <?= csrf_field() ?>
                                <button class="btn btn-success btn-sm" onclick="return confirm('Approuver ?')">Approuver</button>
                            </form>
                            <form method="post" action="<?= base_url('comment/status/' . $c->id . '/pending') ?>" class="d-inline">
                                <?= csrf_field() ?>
                                <button class="btn btn-secondary btn-sm" onclick="return confirm('Remettre en attente ?')">En attente</button>
                            </form>
                            <form method="post" action="<?= base_url('comment/delete/' . $c->id) ?>" class="d-inline">
                                <?= csrf_field() ?>
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer définitivement ?')">Supprimer</button>
                            </form>
                            <!--data- = attributs html qui passent infos au js, toggle déclenche le collapse target cible-->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#reply-<?= $c->id ?>">
                                Répondre
                            </button>
                        </div>
                        <!-- Form de réponse collapse(dépliable) -->
                        <div class="collapse mt-2" id="reply-<?= $c->id ?>">
                            <form method="post" action="<?= base_url('comment/reply') ?>" id="form-reply-<?= $c->id ?>">
                                <?= csrf_field() ?>
                                <input type="hidden" name="parent_id" value="<?= $c->id ?>">
                                <!--ici on a recette_id et pas recipe car l'objet $c est construit à partir de la bdd -->
                                <input type="hidden" name="recipe_id" value="<?= $c->recipe_id ?>">
                                <div id="toolbar-reply-<?= $c->id ?>">
                                    <span class="ql-formats">
                                        <button class="ql-bold"></button>
                                        <button class="ql-italic"></button>
                                        <button class="ql-underline"></button>
                                    </span>
                                </div>
                                <div id="editor-reply-<?= $c->id ?>" style="background:white; height:100px;"></div>
                                <input type="hidden" name="content" id="content-<?= $c->id ?>">
                                <input type="submit" value="envoyer" class="btn btn-primary btn-sm mt-2">
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center">Aucun commentaire</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>

<?= $this->section('customJs') ?>

<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    <?php foreach ($comments as $c): ?>
    (function() {
        // Quill initialisé directement, pas dans shown.bs.collapse
        const quill = new Quill('#editor-reply-<?= $c->id ?>', {
            modules: { toolbar: '#toolbar-reply-<?= $c->id ?>' },
            placeholder: 'Répondre...',
            theme: 'snow',
        });

        document.querySelector('#toolbar-reply-<?= $c->id ?> .ql-bold').setAttribute('title', 'Gras');
        document.querySelector('#toolbar-reply-<?= $c->id ?> .ql-italic').setAttribute('title', 'Italique');
        document.querySelector('#toolbar-reply-<?= $c->id ?> .ql-underline').setAttribute('title', 'Souligné');

        document.getElementById('form-reply-<?= $c->id ?>').addEventListener('submit', (e) => {
            if (quill.getText().trim().length <= 1) {
                e.preventDefault();
                alert('Veuillez écrire une réponse');
                return;
            }
            document.getElementById('content-<?= $c->id ?>').value = quill.root.innerHTML;
        });
    })();
    <?php endforeach; ?>
});
</script>
<?= $this->endSection() ?>