<?php
//buffering start
ob_start(); 

$film = $requeteFilm->fetch();

                ?>
                <div class="cardFilmComplet">
                    <img class="Ubox" alt="où est l'affiche?"  src="./public/img/film/<?= $film['film_afficheURL'] ?>" >
                    <div class="filmNote Ubox"><?= $film['film_note'] ?></div>
                    <div class="filmTitreAnnee Ubox"><h2><?= $film["film_titre"] ?> (<?= $film["film_annee"] ?>)</h2><span><?= $film['duree'] ?><span></div>
                    <div class="filmReal Ubox"><a href="?action=detailPersonne&id=<?= $film['id_personne'] ?>"><?=$film['personne_prenom']?> <?=$film['personne_nom']?></a></div>
                    <div class="filmResume Ubox"><h3>Synopsis</h4><p><?= $film["film_resume"] ?></p></div>
                    <div class="casting Ubox"><h3>Casting</h3>
                        <form action="index.php?action=adminRole&id=<?= $film['id_film'] ?>" name="casting" method="POST">
                            <table>
                                <tr>
                                    <th>ACTEUR</th>
                                    <th>ROLE</th>
                                    <th>Supprimé</th>
                                </tr>
                                <?php
                                    foreach($requeteCasting->fetchAll() as $casting){
                                        if($casting['id_film'] == $film['id_film'] ){
                                            static $i = 0;
                                            ?>
                                            <tr>
                                                <td><?=$casting['personne_prenom']." ".$casting['personne_nom'] ?></td>
                                                <td><?=$casting['role_nom']?></td> 
                                                <td><input type="submit" name="<?=$casting['id_role']?>" value="Supprimé"></input></td>
                                            </tr>

                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                    
                                <tr>
                                    <td>
                                        <label for="idActeur"></label>
                                            <select id="idActeur" name="idActeur">
                                                <option selected disabled>-Ajouter un acteur-</option>
                                                    <?php
                                                        foreach($requeteActeur as $personne ){
                                                            ?>
                                                            <option value="<?=$personne['id_acteur']?>"><?=$personne['personne_nom']." ".$personne['personne_prenom']?></option>
                                                            <?php
                                                        }
                                                        ?>
                                            </select>
                                    </td>
                                    <td>
                                        <label for="idRole"></label>
                                            <select id="idRole" name="idRole">
                                                <option selected disabled>-Ajouter un role-</option>
                                                    <?php
                                                        foreach($requeteRole  as $role ){
                                                            ?>
                                                            <option value="<?=$role['id_role']?>"><?=$role['role_nom']?></option>
                                                            <?php
                                                        }
                                                        ?>
                                            </select>
                                    </td>
                                    <td><input type="submit" name="modCasting" value="Ajouté"></input></td>
                                </tr>
                            </table>
                         </form>
                    </div>
                    <div class="genre Ubox"><h3>Genre</h3>
                        <form>
                    <?php
                        foreach($requeteGenre->fetchAll() as $value){
                           ?>
                            <div>
                                <label for="<?=$value['id_genre']?>"><?=$value['genre_libelle']?></label>
                                <input type='checkbox' id="<?=$value['id_genre']?>" <?= ($value['id_film']==$film['id_film'])? "checked" : "" ?>></input>
                            </div>
                       <?php
                        }
                    ?>
                        <input type='submit' value='Update'></input>
                        </form>
                    </div>
                </div>

<?php
$titre= $film['film_titre'];
$titre_secondaire = "Détail du film".$film['film_titre'];
// buffering end
$contenu = ob_get_clean();
require "view/template.php";