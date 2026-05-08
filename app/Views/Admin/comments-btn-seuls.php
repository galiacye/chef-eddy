<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Tous les commentaires<?= $this->endSection() ?>
<?= $this->section('customcss') ?>

<?= $this->endSection() ?>
<?= $this->section('body') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif ?>

<h2 class="text-center mb-4">Tous les commentaires</h2>

<div class="row">
    <?php if (!empty($comments)): ?>
        <?php foreach ($comments as $c): ?>

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <!-- user_id est ds $c grâce au join du model-->
                <p class="username"><a href="<?= base_url('user/profile/') . $c->user_id ?>"><?= $c->username ?></a></p>
                <!--idem pour recipe_title-->
                <p class="recipe"><?= $c->recipe_title ?></p>
                <p class="com-content"><?= $c->content ?></p>

                <div class="btn-group mb-2">

                <form method="post" action="<?= base_url('comment/status/' . $c->id . '/approved') ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <button class="btn btn-success btn-sm" onclick="return confirm('Approuver ce commentaire ?')">
                        Approuver
                    </button>
                </form>

                <form method="post" action="<?= base_url('comment/delete/' . $c->id) ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer définitivement ce commentaire ? ')">
                        Rejeter et supprimer
                    </button>
                </form>

                <form method="post" action="<?= base_url('comment/status/' . $c->id . '/pending') ?>" class="d-inline">
                    <?= csrf_field() ?>
                    <button class="btn btn-warning btn-sm" onclick="return confirm('Remettre ce commentaire en attente ? ')">
                        Procrastiner et remettre en attente
                    </button>
                </form>

                <form method="post" action="<?= base_url('comment/reply') ?>" class="mt-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="parnet_id" value="<?= $c->id ?>">
                    <!--ici on a recette_id et pas recipe car l'objet $c est construit à partir de la bdd -->
                    <input type="hidden" name="recette_id" value="<?= $c->recette_id ?>">
                    <textarea name="content" roxs="2" class="form-control" placeholder="Répondre"></textarea>
                    <button class="btn btn-primary btn-sm mt-2">Répondre</button>
                </form>

                </div>
<script>
<?php foreach ($comments as $c): ?>
(function() {//Immediatly Invoked Function Expression (IIFE) = creation d'une fct dc d'un nouveau scope,
//permettant de redéclarer const quill plusieurs fois sans conflit. Ici const quill limité au bloc { } le plus proche
    

                  const quill = new Quill('#editor-reply-<?= $c->id ?>', {
        modules: { toolbar: '#toolbar-reply-<?= $c->id ?>' },
        placeholder: 'Répondre...',
        theme: 'snow',
    });
    document.getElementById('form-reply-<?= $c->id ?>').addEventListener('submit', (e) => {
             console.log('getText:', quill.getText());
        console.log('length:', quill.getText().trim().length);
        const text = quill.getText().trim();
        if (text.length <= 1) {
            e.preventDefault();
            alert('Veuillez écrire une réponse');
            return;
        }
        document.getElementById('content-<?= $c->id ?>').value = quill.root.innerHTML;
   
    });
       
})();
<?php endforeach; ?>
</script>
<?= $this->endSection() ?> 
        <?php endforeach; ?>
    <?php else : ?>
    <?php endif; ?>

</div>
<?= $this->endSection() ?>