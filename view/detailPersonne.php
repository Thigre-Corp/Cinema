<?php
//buffering start
ob_start(); ?>


        <?php
            $personne = $requete->fetch();
                ?>
                <div class="cardProfil">
                    <img class="Ubox" alt="où est l'affiche?"  src="./public/img/personne/<?= $personne['personne_photoURL'] ?>" >
                    <div class="etatCivil Ubox">
                        <h2><?=$personne['personne_prenom']?> <?=$personne['personne_nom']?></h2>
                        <p><?= $personne['personne_sexe']= "m" ? "Homme" : "Femme"?> - né le <?=$personne['personne_Naissance']?></p>
                    </div>
                    <div class="film Ubox">
                        <h3>Films Notables</h3>
                    </div>
                    <div class="collab Ubox">
                        <h3>Films Notables</h3>
                    </div>
                </div>

<?php
$titre= $personne['personne_prenom']." ".$personne['personne_nom'];
$titre_secondaire = "Informations sur ".$personne['personne_prenom']." ".$personne['personne_nom'];
// buffering end
$contenu = ob_get_clean();
require "view/template.php";