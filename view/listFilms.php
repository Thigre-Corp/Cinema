<?php
//buffering start
ob_start(); ?>

<p>Il y a <?= $requete->rowCount() ?> films</p>

        <?php
            // modifications pour en faire la page d'accueil....... ne retourne que 3 films.
            $i =0;
            foreach($requete->fetchAll() as $film ){ 
                if (++$i > 3 ){
                    break;
                }
                ?>
                <div class="cardFilmAccueil">
                    <img class="affiche" alt="où est l'affiche?"  src="./public/img/film/<?= $film['film_afficheURL'] ?>" >
                    <span class='titre'><?= $film["film_titre"] ?> (<?= $film["film_annee"] ?>)</span>
                </div>
        <?php } ?>


<?php

$titre= "Liste des films";
$titre_secondaire = "A l'affiche Aujourd'hui";
// buffering end
$contenu = ob_get_clean();
require "view/template.php";

