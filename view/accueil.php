<?php
//buffering start
ob_start(); ?>


        <?php
            //....... ne retourne que 3 films -> rendre l'affichage des trois films aléatoire par rapport à la liste disponible.
            $i =0;
            foreach($requete->fetchAll() as $film ){ 
                if (++$i > 3 ){
                    break;
                }
                ?>
                <div class="cardFilmAccueil Ubox">
                    <a href="?action=detailFilm&id=<?= $film['id_film'] ?>">
                        <img alt="où est l'affiche?"  src="./public/img/film/<?= $film['film_afficheURL'] ?>" >
                        <div><?= $film["film_titre"] ?> (<?= $film["film_annee"] ?>)</div>
                    </a>
                </div>
        <?php } ?>

<?php

$titre= "Accueil";
$titre_secondaire = "A l'affiche Aujourd'hui";
// buffering end
$contenu = ob_get_clean();
require "view/template.php";