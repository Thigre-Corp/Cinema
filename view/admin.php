<?php
ob_start(); ?>

            <div id="adminPage">
<!--OK Ajout film -->
                <div class="addFilm Ubox"> 
                    <h3>Ajouter film</h3>
                    <form action="index.php?action=addFilm" name="addFilm" method="POST"> 
                        <label for="titreFilm">Titre:</label>
                            <input type="text" id="titreFilm" name="titreFilm"><br>
                        <label for="anneeFilm">Année de sortie:</label>
                            <input type="number" id="anneeFilm" name="anneeFilm" min="1870" max="2100"><br>
                        <label for="dureeFilm">Durée (mn):</label>
                            <input type="number" id="dureeFilm" min="0" max="480" step="1" name="dureeFilm"><br>
                        <label for="noteFilm">Note:</label>
                            <input type="number" id="noteFilm" name="noteFilm" min="0" max="5" step="1"><br>
                        <label for="afficheFilmURL">URL Affiche:</label>
                            <input type="text" id="afficheFilmURL" name="afficheFilmURL"><br>
                        <label for="idReal">Réalisateur:</label>
                            <select id="idReal" name="idReal">
                                <option selected disabled>-liste des réalisateurs-</option>
                                <?php
                                    foreach($requeteReal->fetchAll() as $real ){
                                        ?>
                                        <option value="<?=$real['id_realisateur']?>"><?=$real['personne_prenom']." ".$real['personne_nom']?></option>
                                        <?php
                                    }
                                    ?>
                            </select><br>
                        <label for="idGenre">Genre:</label>
                            <select id="idGenre" name="idGenre">
                                <option selected disabled>-liste des genres-</option>
                                <?php
                                    foreach($requeteGenre as $genre ){
                                        ?>
                                        <option value="<?=$genre['id_genre']?>"><?=$genre['genre_libelle']?></option>
                                        <?php
                                    }
                                    ?>
                            </select><br>
                        <label for="resumeFilm">Résumé:</label>
                            <input type="text" id="resumeFilm" name="resumeFilm"><br>
                        <input type="submit" name="addFilm" value="AJOUTER">
                    </form>
                </div>

<!--OK suppression film -->
    <div class="suppFilm Ubox">
        <h3>Supprimer film</h3>
        <form action="index.php?action=suppFilm" name="suppFilm" method="POST"> 
            <label for="idFilm"></label>
                <select id="idFilm" name="idFilm">
                    <option selected value="0">-Supprimer film-</option>
                    <?php
                        foreach($requeteFilm as $film ){
                            ?>
                            <option value="<?=$film['id_film']?>"><?=$film['film_titre']?></option>
                            <?php
                        }
                        ?>
                </select>
            <input type="submit" name="suppFilm" value="SUPPRIMER">
        </form>
    </div>
<!-- Ajout rôle -->
                <div class="addRole Ubox">  
                    <h3>Ajouter  role</h3>
                    <form action="index.php?action=addRole" name="addRole" method="POST">
                        <label for="addRole">Nom:</label>
                            <input type="text" id="addRole" name="addRole"></input>
                        <input type='submit' name='addRole' value="AJOUTER"></input>
                    </form>
                </div>
<!-- Suppression rôle -->
                <div class="suppRole Ubox">  
                    <h3>Supprimer role</h3>
                    <form action="index.php?action=suppRole"name="suppRole" method="POST">
                        <label for="suppRole"></label>
                            <select id="suppRole" name="suppRole">
                                <option selected value="0">-Supprimer rôle-</option>
                                <?php
                                    foreach($requeteRole as $role ){
                                        ?>
                                        <option value="<?=$role['id_role']?>"><?=$role['role_nom']?></option>
                                        <?php
                                    }
                                    ?>
                            </select>
                                    <input type='submit' name='suppRole' value='SUPPRIMER'></input>
                    </form>
                </div>
<!-- Ajout genre -->
                <div class="addGenre Ubox">  
                    <h3>Ajouter genre</h3>
                    <form action="index.php?action=addGenre" name="addGenre" method="POST">
                                                <label for="genreLibelle">Libellé du genre:</label>
                            <input type="text" id="genreLibelle" name="genreLibelle"></input>
                        <input type="submit" name="addGenre" value="AJOUTER">
                    </form>
                </div>
<!-- Suppression genre -->
                <div class="suppGenre Ubox">  
                    <h3>Supprimer genre</h3>
                    <form action="index.php?action=suppGenre" name="suppGenre" method="POST">
                        <label for="idGenre">Genre:</label>
                            <select id="idGenre" name="idGenre">
                                <option selected value="0">-supprimer genre-</option>
                                <?php
                                    foreach($requeteGenre as $genre ){
                                        ?>
                                        <option value="<?=$genre['id_genre']?>"><?=$genre['genre_libelle']?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        <input type="submit" name="suppGenre" value="SUPPRIMER">
                    </form>
                </div>
<!-- ajout personne -->
                <div class="addPersonne Ubox">
                    <h3>Ajouter Personne</h3>
                    <form action="index.php?action=addPersonne" name="addPersonne" method="POST">
                        
                        <label for="personneNom">Nom:</label>
                            <input type="text" id="personneNom" name="personneNom"></input><br>
                        <label for="personnePrenom">Prénom:</label>
                            <input type="text" id="personnePrenom" name="personnePrenom"></input><br>
                        <label for="personneSexe">Sexe:</label>
                                <select id="personneSexe" name="personneSexe">
                                    <option selected value="m">Homme</option>
                                    <option value ='f'>Femme</option>
                                </select><br>
                        <label for="personneDateNaissance">Date de Naissance:</label>
                                <input type="date" id="personneDateNaissance" name="personneDateNaissance"></input><br>
                        <label for="personnePhotoURL">URL Photo:</label>
                                <input type="text" id="personnePhotoURL" name="personnePhotoURL"></input><br>
                        <label for="estActeur">Acteur:</label>
                                <input type="checkbox" id="estActeur" name="estActeur">
                        <label for="estReal">Réalisateur:</label>
                                <input type="checkbox" id="estReal" name="estReal"><br>
                        <label for="supprimerPersonne">Supprimer:</label>
                                <input type="checkbox" id="supprimerPersonne" name="supprimerPersonne"><br>
                        <input type="submit" name="addPersonne" value="AJOUTER">
                    </form>
                </div>
<!-- suppression personne -->
                <div class="suppPersonne Ubox">
                    <h3>Supprimer Personne</h3>
                    <form action="index.php?action=suppPersonne" name="suppPersonne" method="POST">
                        <label for="idGenre">Personne:</label>
                            <select id="idGenre" name="idGenre">
                                <option selected value="0">-supprimer personne-</option>
                                <?php
                                    foreach($requetePersonne as $personne ){
                                        ?>
                                        <option value="<?=$personne['id_personne']?>"><?=$personne['personne_nom']." ".$personne['personne_prenom']?></option>
                                        <?php
                                    }
                                ?>
                            </select><br>
                        <input type="submit" name="suppPersonne" value="SUPPRIMER">
                    </form>
                </div>


<!-- fin HTML -->


<?php

$titre= "Admin";
$titre_secondaire = "Admin";
$contenu = ob_get_clean();
require "view/template.php";

//buffering start
ob_start(); ?>