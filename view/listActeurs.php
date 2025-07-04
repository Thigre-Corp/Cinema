<?php

ob_start(); ?>

<!--p>Il y a <?= $requete->rowCount() ?> acteurs</p-->

        <?php
            foreach($requete->fetchAll() as $personne ){ 
                ?>
                <div class="cardProfilList">
                    <a href="?action=detailPersonne&id=<?= $personne['id_personne'] ?>">
                        <img class="Ubox" alt="où est l'affiche?"  src="./public/img/personne/<?= $personne['personne_photoURL'] ?>" >
                            <div class="etatCivil Ubox">
                                <h2><?=$personne['personne_prenom']?> <?=$personne['personne_nom']?></h2>
                            </div>
                    </a>
                </div>

<?php }

$titre= "Liste des acteurs";
$titre_secondaire = "Liste des acteurs";
$contenu = ob_get_clean();
require "view/template.php";

//buffering start
ob_start(); ?>