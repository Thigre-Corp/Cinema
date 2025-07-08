<?php
//buffering start
ob_start(); 

$film = $requeteFilm->fetch();

?>
<div class="cardFilmComplet">
    <img class="Ubox" alt="où est l'affiche?"  src="./public/img/film/<?= $film['film_afficheURL'] ?>" >
    <div class="filmNote Ubox"><?= $film['film_note'] ?></div>
    <div class="filmTitreAnnee Ubox">
        <h2>
            <a href="?action=modFilm&id=<?= $film['id_film'] ?>"><?= $film["film_titre"] ?> (<?= $film["film_annee"] ?>)</a>
        </h2>
        <span><?= $film['duree'] ?><span>

        </div>
    <div class="filmReal Ubox"><a href="?action=detailPersonne&id=<?= $film['id_personne'] ?>"><?=$film['personne_prenom']?> <?=$film['personne_nom']?></a></div>
    <div class="filmResume Ubox"><h3>Synopsis</h4><p><?= $film["film_resume"] ?></p></div>
    <div class="casting Ubox"><h3>Casting</h3>
        <table>
            <tr>
                <th>ACTEUR</th>
                <th>ROLE</th>
            </tr>
            <?php
                foreach($requeteCasting->fetchAll() as $casting){
                    if($casting['id_film'] == $film['id_film'] ){
                        static $i = 0;
                        ?>
                        <tr>
                            <td><?=$casting['personne_prenom']." ".$casting['personne_nom'] ?></td>
                            <td><?=$casting['role_nom']?></td> 
                        </tr>

                        <?php
                        $i++;
                    }
                }
                ?>
        </table>
    </div>
    <div class="genre Ubox"><h3>Genres</h3>
        <?php
                foreach($requeteGenreFilm->fetchAll() as $genre){
                    echo "<p>".$genre['genre_libelle']."</p>";
                }
        ?>
    </div>
</div>

<?php

$titre= $film['film_titre'];
$titre_secondaire = "Détail du film".$film['film_titre'];
// buffering end
$contenu = ob_get_clean();
require "view/template.php";