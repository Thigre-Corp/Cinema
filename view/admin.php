<?php

ob_start(); ?>

            <div id="adminPage">
<!-- administration des films-->
                <div class="adminFilm"> 
                    <h3>Ajouter  un film</h3>
                    <form action="index.php?action=adminFilm" name="film" method="POST"> 
                        <!-- <label for="idFilm">Créer ou modifier un film:</label>
                            <select id="idFilm" name="idFilm">
                                <option selected value="0">-créer un nouveau film-</option>
                                <?php
                                 
                                    //     <?php
                                    // }
                                    ?>                                 -->
                            </select><br>
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
                        <label for="supprimerFilm">Supprimer:</label>
                            <input type="checkbox" id="supprimerFilm" name="supprimerFilm"><br>
                        <input type="submit" name="modFilm" value="ENVOYER">
                    </form>
                </div>
<!-- administration des personnes -->
                <div class="adminPersonnes">
                    <h3>Ajouter  Personne</h3>
                    <form action="index.php?action=adminPersonne" name="personne" method="POST">
                        
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
                        <input type="submit" name="modPersonne" value="ENVOYER">
                    </form>
                </div>
<!-- administration des castings -->
                <div class="adminCasting">  
                    <h3>Ajouter  role</h3>
                    <form name="casting" method="POST">
                        <label for="personneNom">Nom:</label>
                        <input type="text" id="personneNom" name="personneNom"></input>





                    </form>
                </div>
<!-- administration des genres -->
                <div class="adminGenre">  
                    <h3>Ajouter  un genre</h3>
                    <form action="index.php?action=adminGenre" name="genre" method="POST">
                        <label for="idGenre">Genre:</label>
                            <select id="idGenre" name="idGenre">
                                <option selected value="0">-créer un genre-</option>
                                <?php
                                    foreach($requeteGenre as $genre ){
                                        ?>
                                        <option value="<?=$genre['id_genre']?>"><?=$genre['genre_libelle']?></option>
                                        <?php
                                    }
                                    ?>
                            </select><br>
                        <label for="genreLibelle">Libellé du genre:</label>
                            <input type="text" id="genreLibelle" name="genreLibelle"></input>
                        <label for="supprimerGenre">Supprimer:</label>
                            <input type="checkbox" id="supprimerGenre" name="supprimerGenre"><br>
                        <input type="submit" name="modGenre" value="ENVOYER">
                    </form>
                </div>
            </div>

<!-- fin HTML -->


<?php

$titre= "Admin";
$titre_secondaire = "Admin";
$contenu = ob_get_clean();
require "view/template.php";

//buffering start
ob_start(); ?>