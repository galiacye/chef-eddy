Mais attention, section() ne supporte pas <?= ?> à l'intérieur — CI4 capture le texte brut de la section. Il faut faire autrement :


php<?= $this->section('description') ?>
Découvrez la recette <?= esc($recipe->title) ?> sur Chef Eddy.
<?= $this->endSection() ?>


tester car certaines versions de CI4 le supportent, d'autres non. Si la description s'affiche vide ou cassée dans le source, remplacer par :
php<?php $this->section('description') ?>
<?= 'Découvrez la recette ' . esc($recipe->title) . ' sur Chef Eddy.' ?>
<?php $this->endSection() ?>