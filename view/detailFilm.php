<?php
//buffering start
ob_start(); ?>


        <?php
           // var_dump($requete->fetchAll());
            foreach($requete->fetchAll() as $film ){ 
                ?>
                <div class="cardFilmComplet">
                    <img class="Ubox" alt="où est l'affiche?"  src="./public/img/film/<?= $film['film_afficheURL'] ?>" >
                    <div class="filmNote Ubox"><?= $film['film_note'] ?></div>
                    <div class="filmTitreAnnee Ubox"><h2><?= $film["film_titre"] ?> (<?= $film["film_annee"] ?>)</h2><span><?= $film['duree'] ?><span></div>
                    <div class="filmReal Ubox"><a href="?action=detailPersonne&id=<?= $film['id_personne'] ?>"><?=$film['personne_prenom']?> <?=$film['personne_nom']?></a></div>
                    <div class="filmResume Ubox"><h3>Synopsis</h4><p><?= $film["film_resume"] ?></p></div>
                    <div class="casting Ubox">casting</div>
                    <!--a href="?action=detailFilm&id=<?= $film['id_film'] ?>">
                    </a-->
                </div>
        <?php } ?>

<?php
var_dump($film);
$titre= $film['film_titre'];
$titre_secondaire = "Détail du film".$film['film_titre'];
// buffering end
$contenu = ob_get_clean();
require "view/template.php";