<?php
//buffering start
ob_start(); ?>

<p>Il y a <?= $requete->rowCount() ?> films</p>

        <?php
            $i =0;
            foreach($requete->fetchAll() as $film ){ 
                ?>
                <div class="cardFilmAccueil">
                    <a href="?action=detailFilm&id=<?= $film['id_film'] ?>">
                        <img alt="où est l'affiche?"  src="./public/img/film/<?= $film['film_afficheURL'] ?>" >
                        <div><?= $film["film_titre"] ?> (<?= $film["film_annee"] ?>)</div>
                    </a>
                </div>
        <?php } ?>


<?php

$titre= "Liste des films";
$titre_secondaire = "A l'affiche Aujourd'hui";
// buffering end
$contenu = ob_get_clean();
require "view/template.php";

