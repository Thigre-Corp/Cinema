<?php

namespace Controller; //espace virtuel
use Model\Connect;

class CinemaController {

    // page d'accueil

    public function accueil() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT film_titre, film_annee, film_afficheURL, id_film
            FROM film
            ");
        require "view/accueil.php";
    }

    // lister les films

    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT film_titre, film_annee, film_afficheURL , id_film
            FROM film
            ");
        require "view/listFilms.php";
    }
    
    // LISTER ACTEURS
    
    public function listActeurs() { // OK

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT p.personne_nom, p.personne_prenom, p.personne_photoURL, p.id_personne
            FROM personne p
            RIGHT JOIN acteur a
            ON a.id_personne = p.id_personne
            ");
        require "view/listActeurs.php";
    }

    // LISTER REALISATEURS
    public function listRealisateurs() { // OK

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT p.personne_nom, p.personne_prenom, p.personne_photoURL, p.id_personne
            FROM personne p
            RIGHT JOIN realisateur r
            ON r.id_personne = p.id_personne
            ");
        require "view/listRealisateurs.php";
    }

    //detail acteur selon id ---- pas nécessaire / cf détail personne
/*
    public function detailActeur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            SELECT *
            FROM personne
            WHERE id_personne = :id
            ");
        $requete->execute(["id" =>$id]);
        require "view/detailActeur.php";
    }
*/
    //détail film selon id

    public function detailFilm($id) { // ajouter casting / rôle, gref, la totale :)
        $pdo = Connect::seConnecter();
        $requeteFilm = $pdo->prepare(
            "
                SELECT f.* , CONCAT(f.film_duree DIV 60, 'H', f.film_duree MOD 60) AS duree, p.personne_nom, p.personne_prenom, p.id_personne
                FROM film f
                INNER JOIN realisateur r
                ON f.id_realisateur = r.id_realisateur
                LEFT JOIN personne p
                ON r.id_personne = p.id_personne
                WHERE f.id_film = :id
            ");
        $requeteFilm->execute(["id" =>$id]);
        $requeteCasting = $pdo->query(
            "
                SELECT c.id_film , r.id_role, r.role_nom , p.personne_nom, p.personne_prenom
                FROM casting c 
                INNER JOIN acteur a
                ON c.id_acteur = a.id_acteur
                INNER JOIN role r
                ON c.id_role = r.id_role
                INNER JOIN personne p
                ON a.id_personne = p.id_personne
            ");
        $requeteActeur = $pdo->query("
                SELECT p.personne_nom, p.personne_prenom, a.id_acteur
                FROM personne p
                RIGHT JOIN acteur a
                ON a.id_personne = p.id_personne
            ");
        $requeteRole = $pdo->query("
                SELECT r.role_nom, r.id_role
                FROM role r
            ");
        

        require "view/detailFilm.php";
    }

    // détail personne selon id

    public function detailPersonne($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                SELECT *
                FROM personne
                WHERE  id_personne = :id
            ");
        $requete->execute(["id" =>$id]);
        require "view/detailPersonne.php";
    }

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

        require "view/admin.php";
    }

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
}