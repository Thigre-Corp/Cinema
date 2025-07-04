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
    
    public function listActeurs() { // à corriger.... voir queries

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT p.personne_nom, p.personne_prenom
            FROM personne p
            RIGHT JOIN acteur a
            ON a.id_personne = p.id_personne
            ");
        require "view/listActeurs.php";
    }

    //detail acteur selon id

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

    //détail film selon id

    public function detailFilm($id) { // ajouter casting / rôle, gref, la totale :)
    $pdo = Connect::seConnecter();
    $requete = $pdo->prepare(
        "
            SELECT f.* , CONCAT(f.film_duree DIV 60, 'H', f.film_duree MOD 60) AS duree, p.personne_nom, p.personne_prenom, p.id_personne
            FROM film f
            INNER JOIN realisateur r
            ON f.id_realisateur = r.id_realisateur
            LEFT JOIN personne p
            ON r.id_personne = p.id_personne
            WHERE f.id_film = :id
        ");
    $requete->execute(["id" =>$id]);
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