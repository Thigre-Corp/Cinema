<?php
/******************************************************************
 * 
 * 
 *  Controller page d'administration
 * 
 * 
 * 
 ******************************************************************/

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
//créer rôle
    public function addRole($filmForm){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
            INSERT INTO `role` ( `role_nom`) 
            VALUES ( :addRole);
        ");
        $requete->execute([
            "addRole" => $filmForm,
        ]);
        $this->admin();
    }
//supprimer rôle
    public function suppRole($filmForm){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
            DELETE FROM `role`
            WHERE id_role = :id ;
        ");
        $requete->execute([
            "id" => $filmForm,
        ]);
        $this->admin();
    }
//créer Personne
    public function addPersonne($personneForm){
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
                "personneDateNaissance" => $personneForm["personneDateNaissance"],
                "personnePhotoURL" => $personneForm["personnePhotoURL"]
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
        $this->admin();
    }
//supprimer personne
    public function suppPersonne($personneForm){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
            DELETE FROM `personne`
            WHERE id_personne = :id ;
        ");
        $requete->execute([
            "id" => $personneForm,
        ]);
        $this->admin();
    }
}
