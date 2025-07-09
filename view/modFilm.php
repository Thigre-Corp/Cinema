<?php
//buffering start
ob_start(); 

$film = $requeteFilm->fetch();

?>

<div class="cardFilmComplet">
<!-- Affiches -->
    <div class="filmAffiche Ubox">   
        <form action="index.php?action=updateFilm&subForm=affiche&id=<?= $id?>" name="film" method="POST"> 
            <label for="filmAffiche">Affiche:</label><br>
                <select id="filmAffiche" name="filmAffiche">
                    <?php
                        foreach( scandir('./public/img/film') as $affiche){
                            if(strlen($affiche) >2){

                            echo "<option value='".$affiche."'";
                            if($affiche == $film['film_afficheURL']){
                                echo " selected";
                            }
                            echo ">".$affiche."</input>";
                            }
                        }
                    ?>
                </select>
            <input type='submit' value='MàJ Affiche'></input>
        </form>
    </div>
<!-- Notes -->
    <div class="filmNote Ubox">
        <form action="index.php?action=updateFilm&subForm=note&id=<?= $id?>" name="film" method="POST"> 
            <label for="noteFilm">Note:</label>
                <input type='number' min='0' max='5' step='1' id="filmNote" name="filmNote" value="<?= $film['film_note'] ?>"></input>
            <input type='submit' value='MàJ Note'></input>
        </form>
    </div>
<!-- Titres Années Durées -->
    <div class="filmTitreAnnee Ubox">
        <form action="index.php?action=updateFilm&subForm=titre&id=<?= $id?>" name="film" method="POST"> 
            <label for="filmTitre">Titre:</label>
                <input type='text' id="filmTitre" name="filmTitre" value="<?= $film["film_titre"] ?>"></input><br>
            <input type='submit' value='MàJ Titre'></input>
        </form>
        <form action="index.php?action=updateFilm&subForm=annee&id=<?= $id?>" name="film" method="POST"> 
            <label for="filmAnnee">Durée (mn):</label>
                <input type='number' min='1870' max='2100' step='1' id="filmAnnee" name="filmAnnee" value="<?= $film['film_annee'] ?>"></input><br>
            <input type='submit' value='MàJ Année'></input>
        </form>
        <form action="index.php?action=updateFilm&subForm=duree&id=<?= $id?>" name="film" method="POST"> 
            <label for="filmDuree">Durée (mn):</label>
                <input type='number' min='0' max='480' step='1' id="filmDuree" name="filmDuree" value="<?= $film['duree'] ?>"></input><br>
            <input type='submit' value='MàJ Durée'></input>
        </form>
    </div>
<!-- Réalisateur -->
    <div class="filmReal Ubox">
        <form action="index.php?action=updateFilm&subForm=real&id=<?= $id?>" name="film" method="POST"> 
            <label for="idReal">Réalisateur:</label>
                            <select id="filmReal" name="filmReal">
                                    <?php
                                        foreach($requeteReal as $real ){
                                            echo "<option value='".$real['id_realisateur']."'";
                                            if ( $real['id_personne'] == $film['id_personne'] ){
                                                echo " selected >";
                                            }
                                            else{
                                                echo " >" ;
                                            }
                                        echo $real['personne_nom']." ".$real['personne_prenom']."</option>";
                                        }
                                    ?>
                            </select>
            <input type='submit' value='MàJ Réalisateur'></input>
        </form>
    </div>
<!-- Résumé -->
    <div class="filmResume Ubox">
        <form action="index.php?action=updateFilm&subForm=resume&id=<?= $id?>" name="film" method="POST"> 
            <label for="filmResume">Synopsis</label><br>
                <input style="field-sizing: content;" type='text' id='filmResume' name='filmResume' value='<?= $film["film_resume"] ?>'></input>
            <input type='submit' value='MàJ Synopsis'></input>
        </form>
    </div>
<!-- Résumé -->
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
                            <form action="index.php?action=updateFilm&subForm=deleteC&id=<?= $id?>" name="film" method="POST"> 
                                <td><?=$casting['personne_prenom']." ".$casting['personne_nom'] ?></td>
                                <td><?=$casting['role_nom']?></td> 
                                <td><input type='submit' value='delete' name='<?= $casting['id_role']."*".$casting['id_acteur'] ?>'></input></td>
                            </form>
                        </tr>

                        <?php
                        $i++;
                    }
                }
                ?>
<!--ajout d'un couple acteur/rôle,  existants-->
            <tr>
                <form action="index.php?action=updateFilm&subForm=addC&id=<?= $id?>" name="film" method="POST"> 
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
                    <td>
                        <input type='submit' value='add'></input>  
                    </td>
                </form>
            </tr>
        </table>
    </div>
<!-- Genres -->
    <div class="genre Ubox"><h3>Genre</h3>
        <form action="index.php?action=updateFilm&subForm=genre&id=<?= $id?>" name="film" method="POST"> 
            <?php
                $requeteGenreFilm = $requeteGenreFilm->fetchAll();
                foreach($requeteGenre->fetchAll() as $value){
                ?>
                    <div>
                        <label for="<?=$value['id_genre']?>"><?=$value['genre_libelle']?></label>
                            <input type='checkbox' id="<?=$value['id_genre']?>" name="<?=$value['id_genre']?>" 
                            <?php
                                foreach($requeteGenreFilm as $libelle){
                                    if ($libelle['genre_libelle'] == $value['genre_libelle'] ){
                                        echo "checked";
                                    }
                                }
                            ?>
                            >
                            </input>
                    </div>
            <?php
                    }
            ?>
            <input type='submit' value='Update'></input>
        </form>
    </div>
</form>
</div>

<?php

$titre= $film['film_titre'];
$titre_secondaire = "modification du film".$film['film_titre'];
// buffering end
$contenu = ob_get_clean();
require "view/template.php";