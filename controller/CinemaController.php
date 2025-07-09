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
}