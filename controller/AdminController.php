<?php

namespace Controller; //espace virtuel
use Model\Connect;

class AdminController {

    public function admin() {


        $pdo = Connect::seConnecter();
        $requeteReal = $pdo->query(
            "
            SELECT r.id_realisateur, p.personne_nom, p.personne_prenom 
            FROM realisateur r
            INNER JOIN personne p
            ON r.id_personne = p.id_personne ;
            ");
        $requeteIdFilm = $pdo->query(
            "
            SELECT id_film, film_titre
            FROM film;
            ");
        $requeteGenre = $pdo->query(
            "
            SELECT id_genre, genre_libelle
            FROM genre;
            ");
        $requeteGenre = $requeteGenre->fetchAll();
        $requetePersonne = $pdo->query(
            "
            SELECT id_personne, personne_nom, personne_prenom
            FROM personne;
            ");
        $requetePersonne = $requetePersonne->fetchAll();
        $requeteRole = $pdo->query(
            "
            SELECT *
            FROM role
            "
        );
        $requeteFilm = $pdo->query("
            SELECT id_film, film_titre
            FROM film        
        ");

        require "view/admin.php";
    }
//ajouter film  
    public function addFilm($filmForm){
            $pdo = Connect::seConnecter();
            $requete = $pdo->prepare(
                "
                INSERT INTO `film` ( `film_titre`, `film_annee`, `film_duree`, `film_note`, `film_afficheURL`, `film_resume`, `id_realisateur`) 
                VALUES ( :titre , :annee , :duree , :note , :affiche, :resume , :real);
            ");
            $requete->execute([
                "titre" => htmlspecialchars($filmForm["titreFilm"]),
                "annee" => strval($filmForm["anneeFilm"]),
                "duree" => $filmForm["dureeFilm"],
                "note" => $filmForm["noteFilm"],
                "affiche" => $filmForm["afficheFilmURL"],
                "resume" => $filmForm["resumeFilm"],
                "real" => $filmForm["idReal"]  
            ]);
            $this->admin();
    }
//supprimer film  
    public function suppFilm($filmForm){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
            DELETE FROM `film`
            WHERE id_film = :id ;
        ");
        $requete->execute([
            "id" => $filmForm
        ]);
        $this->admin();
    }
//ajouter genre
    public function addGenre($filmForm){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
            INSERT INTO `genre` ( `genre_libelle`) 
            VALUES ( :genreLibelle);
        ");
        $requete->execute([
            "genreLibelle" => $filmForm,
        ]);
        $this->admin();
    }
//supprimer genre
    public function suppGenre($filmForm){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
            DELETE FROM `genre`
            WHERE id_genre = :id ;
        ");
        $requete->execute([
            "id" => $filmForm,
        ]);
        $this->admin();
    }



}
/*
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function adminFilm($filmForm){
    //suppression du film
        if(isset($filmForm["supprimerFilm"])){
            if ($filmForm['supprimerFilm'] == 'on' && $filmForm["idFilm"] !=  '0' ){
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare(
                    "
                    DELETE FROM `film`
                    WHERE id_film = :id ;
                ");
                $requete->execute([
                    "id" => $filmForm["idFilm"]  
                ]);
                echo "<script type='text/javascript'>alert('Film Supprimé !');</script>" ;
            }

        }
    //création du film        
        else if ($filmForm["idFilm"] ==  '0') {
            $pdo = Connect::seConnecter();
            $requete = $pdo->prepare(
                "
                INSERT INTO `film` ( `film_titre`, `film_annee`, `film_duree`, `film_note`, `film_afficheURL`, `film_resume`, `id_realisateur`) 
                VALUES ( :titre , :annee , :duree , :note , :affiche, :resume , :real);
            ");
            $requete->execute([
                "titre" => htmlspecialchars($filmForm["titreFilm"]),
                "annee" => strval($filmForm["anneeFilm"]),
                "duree" => $filmForm["dureeFilm"],
                "note" => $filmForm["noteFilm"],
                "affiche" => $filmForm["afficheFilmURL"],
                "resume" => $filmForm["resumeFilm"],
                "real" => $filmForm["idReal"]  
            ]);
            echo "<script type='text/javascript'>alert('Film créé');</script>" ;
        }
    }

    public function adminGenre($genreForm){
    //supression du Genre
       if(isset($genreForm["supprimerGenre"])){
            if ($genreForm['supprimerGenre'] == 'on' && $genreForm["idGenre"] !=  '0' ){
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare(
                    "
                    DELETE FROM `genre`
                    WHERE id_genre = :id ;
                ");
                $requete->execute([
                    "id" => $genreForm["idGenre"]  
                ]);
                echo "<script type='text/javascript'>alert('Genre supprimé !');</script>" ;
            }

        }
    //création du Genre    
        else if ($genreForm["idGenre"] ==  '0') {
            $pdo = Connect::seConnecter();
            $requete = $pdo->prepare(
                "
                INSERT INTO `genre` ( `genre_libelle`) 
                VALUES ( :genreLibelle);
            ");
            $filtersArguments = array(
                        'idGenre' => FILTER_VALIDATE_INT,
                        'genreLibelle' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'modGenre' => FILTER_SANITIZE_ENCODED,
                        'supprimerGenre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
                    );

            $requete->execute([
                "genreLibelle" => htmlspecialchars($genreForm["genreLibelle"]),
            ]);
            echo "<script type='text/javascript'>alert('Genre créé');</script>" ;
        }
    }

    public function adminPersonne($personneForm){
    //SUPRESSION DE PERSONNE
       if(isset($personneForm["supprimerPersonne"])){
            if ($personneForm['supprimerPersonne'] == 'on' && $personneForm["idPersonne"] !=  '0' ){
                $pdo = Connect::seConnecter();
                $requete = $pdo->prepare(
                    "
                    SELECT p.id_personne, r.id_realisateur, a.id_acteur
                    FROM personne p
                    LEFT JOIN realisateur r
                    ON p.id_personne = r.id_personne
                    LEFT JOIN acteur a
                    ON p.id_personne = a.id_personne
                    WHERE p.id_personne = :idPersonne
                    ");
                $requete->execute([
                    "idPersonne" => $personneForm["idPersonne"] 
                ]);
                $deleteIDs = $requete->fetch();

        //si une ID acteur existe, la supprimer
                if(is_int($deleteIDs["id_acteur"])){
                    $requete = $pdo->prepare(
                        "
                        DELETE FROM `acteur`
                        WHERE id_personne = :id ;
                    ");
                    $requete->execute([
                        "id" => $personneForm["idPersonne"]  
                    ]);
                }
        //si une ID realisateur existe, la supprimer
                if(is_int($deleteIDs["id_realisateur"])){
                    $requete = $pdo->prepare(
                        "
                        DELETE FROM `realisateur`
                        WHERE id_personne = :id ;
                    ");
                    $requete->execute([
                        "id" => $personneForm["idPersonne"]  
                    ]);
                }
     //supprimer enfin la personne
                $requete = $pdo->prepare(
                    "
                    DELETE FROM `personne`
                    WHERE id_personne = :id ;
                ");
                $requete->execute([
                    "id" => $personneForm["idPersonne"]  
                ]);
                echo "<script type='text/javascript'>alert('Personne supprimée !');</script>" ;
            }

        }
    //CREATION DE PERSONNE        
        else if($personneForm["idPersonne"] ==  '0') {
            $pdo = Connect::seConnecter();
            $requete = $pdo->prepare(
                "
                INSERT INTO `personne` ( `personne_nom` , `personne_prenom`, `personne_sexe`, `personne_dateNaissance`, `personne_photoURL`)
                VALUES ( :personneNom , :personnePrenom , :personneSexe , :personneDateNaissance, :personnePhotoURL);
            ");
            $requete->execute([
                "personneNom" => $personneForm["personneNom"],
                "personnePrenom" => $personneForm["personnePrenom"],
                "personneSexe" => $personneForm["personneSexe"],
                "personneDateNaissance" => date('Y-m-d', strtotime($personneForm["personneDateNaissance"])),
                "personnePhotoURL" => $personneForm["personnePhotoURL"],
            ]);
            $requeteIdPersonne = $pdo->prepare("
                SELECT `id_personne`
                FROM personne
                WHERE (personne_nom = :personneNom) AND (personne_prenom = :personnePrenom) ;
            ");
            $requeteIdPersonne->execute([
                "personneNom" => $personneForm["personneNom"],
                "personnePrenom" => $personneForm["personnePrenom"]
            ]);
            $requeteIdPersonne = $requeteIdPersonne->fetch();
            var_dump($requeteIdPersonne);

            if ($personneForm["estActeur"] == 'on'){
                $requete = $pdo->prepare(
                    "
                    INSERT INTO `acteur` ( `id_personne`)
                    VALUES ( :idPersonne);
                ");
                $requete->execute([
                    "idPersonne" => $requeteIdPersonne["id_personne"]
                    ]);
            }

            if ($personneForm["estReal"] == 'on'){
                $requete = $pdo->prepare(
                    "
                    INSERT INTO `realisateur` ( `id_personne`)
                    VALUES ( :idPersonne);
                ");
                $requete->execute([
                    "idPersonne" => $requeteIdPersonne["id_personne"]
                    ]);
            }

            echo "<script type='text/javascript'>alert(".var_dump($personneForm)."'Personne créé');</script>" ;
        }

    }

*/