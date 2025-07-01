<?php

namespace Controller;
use Model\Connect;

class CinemaController {

    // lister les films

    public function listFilms() {
        $pdo = Connect::seConnecter();
        $requete = $pdo->query("
            SELECT film_titre, film_annee, film_afficheURL 
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

    public function detActeur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare("
            SELECT *
            FROM personne
            WHERE id_personne = :id
            ");
        $requete->execute(["id" =>$id]);
        require "view/detaileActeur.php";
    }

}