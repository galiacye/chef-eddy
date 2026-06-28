<?= $this->extend('layout') ?>

<?= $this->section('title') ?>
<title>Mentions légales</title>
<?= $this->endSection() ?>

<?= $this->section('custom-css') ?>
<link href="<?= base_url('css/legal.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>


<?= $this->section('body') ?>
<div class="container rgpd px-4 py-4">
    <h1 class="m-4">Mentions légales</h1>

    <h4>Éditeur du site</h4>
    <p>Chef Eddy est un site développé dans le cadre d'une formation DWWM, à titre de projet pédagogique.</p>

    <h4>Hébergement</h4>
    <p>Résurgences, 111, rue Consolat</p>

    <h4>Données personnelles</h4>
    <p>Lors de votre inscription, Chef Eddy collecte les données suivantes : pseudo, email, mot de passe (haché à l'aide d'un algorithme sécurisé), nom et prénom (facultatifs), et éventuellement une photo de profil.</p>
    <p>Ces données sont utilisées uniquement pour la gestion de votre compte, l'accès à votre espace personnel et la publication de vos recettes et commentaires.</p>
    <p>Vos données ne sont ni vendues, ni transmises à des tiers.</p>

    <h4>Durée de conservation</h4>
    <p>Vos données sont conservées tant que votre compte est actif. Vous pouvez demander leur suppression à tout moment.</p>

    <h4>Vos droits</h4>
    <p>Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez d'un droit d'accès, de rectification et de suppression de vos données. Pour exercer ce droit, contactez-nous à : [email de contact].</p>

    <h4>Cookies</h4>
    <p>Ce site utilise un cookie de session technique, nécessaire à votre connexion. Aucun cookie publicitaire ou de suivi n'est utilisé.</p>
</div>
<?= $this->endSection() ?>