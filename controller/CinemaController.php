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

    //Creer casting
    public function creerCasting($idFilm, $idActeur, $idRole) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            INSERT INTO casting (id_film , id_acteur, id_role)
            VALUES (:idFilm, :idActeur, :idRole)
            ");
        $requete->execute([
            "idFilm" => $idFilm,
            "idActeur" => $idActeur,
            "idRole" => $idRole
        ]);
    }

    //supprimer casting
    public function supprimerCasting($idFilm, $idRole) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            DELETE FROM casting 
            WHERE (id_film = :idFilm ) AND( id_role = :idRole)
            ");
        $requete->execute([
            "idFilm" => $idFilm,
            "idRole" => $idRole
        ]);
    }

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
        $requeteGenreFilm = $pdo->prepare("
                SELECT ge.id_genre, ge.genre_libelle, a.id_film
						FROM genre ge 
						LEFT JOIN appartenir a
	               ON ge.id_genre = a.id_genre
	               WHERE a.id_film = :id
                   ");
        $requeteGenreFilm->execute(["id" => $id]);

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

    public function modFilm($id){
        $pdo = Connect::seConnecter();
        $requeteFilm = $pdo->prepare(
            "
                SELECT f.* , f.film_duree AS duree, p.personne_nom, p.personne_prenom, p.id_personne
                FROM film f
                INNER JOIN realisateur r
                ON f.id_realisateur = r.id_realisateur
                LEFT JOIN personne p
                ON r.id_personne = p.id_personne
                WHERE f.id_film = :id
            ");
        $requeteFilm->execute(["id" =>$id]);
        $requeteCasting = $pdo->prepare(
            "
                SELECT c.id_film , r.id_role, a.id_acteur, r.role_nom , p.personne_nom, p.personne_prenom
                FROM casting c 
                INNER JOIN acteur a
                ON c.id_acteur = a.id_acteur
                INNER JOIN role r
                ON c.id_role = r.id_role
                INNER JOIN personne p
                ON a.id_personne = p.id_personne
                WHERE c.id_film = :id
            ");
        $requeteCasting->execute(["id" =>$id]);   
        $requeteGenreFilm = $pdo->prepare("
                SELECT ge.id_genre, ge.genre_libelle, a.id_film
						FROM genre ge 
						LEFT JOIN appartenir a
	               ON ge.id_genre = a.id_genre
	               WHERE a.id_film = :id
                   ");
        $requeteGenreFilm->execute(["id" => $id]);
        $requeteGenre = $pdo->query("
                SELECT *
				FROM genre ge 
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
        $requeteGenre = $pdo->query("
                SELECT g.*
                FROM genre g  
            ");
        $requeteReal = $pdo->query("
                SELECT p.personne_prenom, p.personne_nom, r.id_realisateur, p.id_personne
                FROM realisateur r
                INNER JOIN personne p
                ON r.id_personne = p.id_personne
                ");

        require "view/modFilm.php";
    }

    public function udAffiche($id, $filteredPost){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                UPDATE film
                SET film_afficheURL = :filteredPost
                WHERE  id_film = :id
            ");
        $requete->execute(["id" =>$id , "filteredPost" => $filteredPost]);
       $this::modFilm($id);
    }

    public function udNote($id, $filteredPost){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                UPDATE film
                SET film_note = :filteredPost
                WHERE  id_film = :id
            ");
        $requete->execute(["id" =>$id , "filteredPost" => $filteredPost]);
       $this::modFilm($id);
    }

    public function udTitre($id, $filteredPost){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                UPDATE film
                SET film_titre = :filteredPost
                WHERE  id_film = :id
            ");
        $requete->execute(["id" =>$id , "filteredPost" => $filteredPost]);
       $this::modFilm($id);
    }

    public function udAnnee($id, $filteredPost){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                UPDATE film
                SET film_annee = :filteredPost
                WHERE  id_film = :id
            ");
        $requete->execute(["id" =>$id , "filteredPost" => $filteredPost]);
       $this::modFilm($id);
    }

    public function udDuree($id, $filteredPost){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                UPDATE film
                SET film_duree = :filteredPost
                WHERE  id_film = :id
            ");
        $requete->execute(["id" =>$id , "filteredPost" => $filteredPost]);
       $this::modFilm($id);
    }

    public function udReal($id, $filteredPost){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                UPDATE film
                SET id_realisateur = :filteredPost
                WHERE  id_film = :id
            ");
        $requete->execute(["id" =>$id , "filteredPost" => $filteredPost]);
       $this::modFilm($id);
    }

    public function udResume($id, $filteredPost){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                UPDATE film
                SET film_resume = :filteredPost
                WHERE  id_film = :id
            ");
        $requete->execute(["id" =>$id , "filteredPost" => $filteredPost]);
       $this::modFilm($id);
    }

    public function udDeleteRole($id, $$filteredActorID, $filteredRoleID){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                DELETE FROM casting
                WHERE......
            ");
        $requete->execute(["id" =>$id , "filteredPost" => $filteredPost]);
       $this::modFilm($id);
    }



}