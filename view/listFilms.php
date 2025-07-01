<?php
//buffering start
ob_start(); ?>

<p>Il y a <?= $requete->rowCount() ?> films</p>


        <?php
            foreach($requete->fetchAll() as $film ){ ?>
                <div class="cardcardFilmAccueil">
                    <img class="affiche" scr=<?php echo "'".$film["film_afficheURL"]."'"; ?> >
                    <span class='titre'><?= $film["film_titre"] ?> (<?= $film["film_annee"] ?>)</span>
                </div>
        <?php } ?>


<?php

$titre= "Liste des films";
$titre_secondaire = "A l'affiche Aujourd'hui";
// buffering end
$contenu = ob_get_clean();
require "view/template.php";

