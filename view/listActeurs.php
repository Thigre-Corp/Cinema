<?php

ob_start(); ?>

<p>Il y a <?= $requete->rowCount() ?> acteurs</p>

<table>
    <thead>
        <tr>
            <th>NOM</th>
            <th>PRENOM</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($requete->fetchAll() as $acteur ){ ?>
                <tr>
                    <td><?= $acteur["personne_nom"] ?></td>
                    <td><?= $acteur["personne_prenom"] ?></td>
                <tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre= "Liste des acteurs";
$titre_secondaire = "Liste des acteurs";
$contenu = ob_get_clean();
require "view/template.php";
