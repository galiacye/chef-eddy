<?= $this->extend('layoutAdmin') ?>
<?= $this->section('titre') ?>Dashboard<?= $this->endSection() ?>

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

    <h1 class="dash-title">Tableau de bord</h1>

    <!-- Stats . entiers esc inutile-->
    <div class="stats-row">
        <div class="stat-card">
            <span class="stat-number"><?= $nb_users ?></span>
            <span class="stat-label">Utilisateurs</span>
        </div>
        <div class="stat-card">
            <span class="stat-number"><?= $nb_recipes ?></span>
            <span class="stat-label">Recettes</span>
        </div>
        <div class="stat-card stat-warn">
            <span class="stat-number"><?= $nb_recipes_pending ?></span>
            <span class="stat-label">En attente</span>
        </div>
    </div>

    <!-- nav cards -->
    <div class="nav-grid">
        <a href="Admin/users-index" class="nav-card">
            <span class="nav-icon"></span>
            <span class="nav-title">Utilisateurs</span>
            <span class="nav-sub">Comptes, rôles, accès</span>
        </a>
        <a href="Admin/recipes-index" class="nav-card">
            <span class="nav-icon"></span>
            <span class="nav-title">Recettes</span>
            <span class="nav-sub">Gérer, modifier, supprimer</span>
        </a>
        <a href="Admin/ing-index" class="nav-card">
            <span class="nav-icon"></span>
            <span class="nav-title">Ingrédients</span>
            <span class="nav-sub">Voir, supprimer les doublons</span>
        </a>
        <a href="Admin/comments" class="nav-card">
            <span class="nav-icon"></span>
            <span class="nav-title">Commentaires</span>
            <span class="nav-sub">Modérer</span>
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
                        <?= esc($tag->name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="tag-btn mt-2">Choisir</button>
        </form>
        <form action="<?= base_url('Admin/add-tag') ?>" method="post" class="mt-2">
            <?= csrf_field() ?>
            <input type="text" name="name" class="tag-select" placeholder="Nouveau tag" required>
            <button type="submit" class="tag-btn">Ajouter</button>
        </form>
    </div>

</div>

<?= $this->endSection() ?>