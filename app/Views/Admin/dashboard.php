<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?><title>Dashboard</title><?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/Admin/dashboard.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('body') ?>

<div class="dashboard-wrap">

    <?php if (session()->getFlashdata('success')): ?>
        <div class="flash-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

   
   <h1 class="dash-title text-center mb-4">Tableau de bord</h1>

<div class="nav-grid">
    <a href="Admin/users-index" class="nav-card shadow">
        <div class="nav-icon"><i class="bi bi-people"></i></div>
        <div class="nav-title">Utilisateurs <span class="nav-badge"><?= $nb_users ?></span></div>
        <div class="nav-p">Comptes, rôles, accès</div>
    </a>

    <a href="Admin/recipes-index" class="nav-card shadow">
        <div class="nav-icon"><i class="bi bi-journal-text"></i></div>
        <div class="nav-title">
            Recettes <span class="nav-badge"><?= $nb_recipes ?></span>
            <?php if ($nb_recipes_pending > 0): ?>
                <span class="nav-badge-pending nav-badge-warn"><?= $nb_recipes_pending ?> en attente</span>
            <?php endif ?>
        </div>
        <div class="nav-p">Voir, supprimer, mettre en attente</div>
    </a>

    <a href="Admin/comments" class="nav-card shadow">
        <div class="nav-icon"></div>
        <div class="nav-title">Commentaires</div>
        <div class="nav-p">Modérer, supprimer, répondre</div>
    </a>

    <a href="Admin/cat-index" class="nav-card">
        <div class="nav-icon"></div>
        <div class="nav-title">Catégories</div>
        <div class="nav-p">Modifier, Ajouter, Supprimer</div>
    </a>

    <a href="tag/index" class="nav-card">
        <div class="nav-icon"></div>
        <div class="nav-title">Tags</div>
        <div class="nav-p">Modifier, Ajouter, Supprimer</div>
    </a>

    <a href="Admin/ing-index" class="nav-card">
        <div class="nav-icon"></div>
        <div class="nav-title">Ingrédients</div>
        <div class="nav-p">Voir, supprimer les doublons</div>
    </a>
</div>


    <!-- homepage tag -->
    <div class="tag-panel">
        <div class="tag-panel-header">
            <span class="tag-panel-icon"></span>
            <div>
                <p class="tag-panel-title">Tag affiché sur la page d'accueil</p>
                <p class="tag-panel-current">
                    Actuellement : <strong><?= $homepageTag ? esc($homepageTag->name) : 'Aucun' ?></strong>
                </p>
            </div>
        </div>
        <form action="<?= base_url('Admin/set-homepage-tag') ?>" method="post" class="tag-form">
            <?= csrf_field() ?>
            <select name="tag_id" class="tag-select">
                <?php foreach ($tags as $tag): ?>
                    <option value="<?= $tag->id ?>"
                        <?= ($homepageTag && $homepageTag->id == $tag->id) ? 'selected' : '' ?>>
                        <!--$homepage existe-t-il et son id est elle égale à l'id de cetag? si oui le préselectionner-->
                        <?= esc($tag->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="tag-btn btn-blue mt-2">Choisir</button>
        </form>
        <form action="<?= base_url('Admin/add-tag') ?>" method="post" class="mt-2">
            <?= csrf_field() ?>
            <input type="text" name="name" class="tag-select" placeholder="Nouveau tag" required>
            <button type="submit" class="tag-btn btn-emeraude px-3 py-1">Ajouter</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>