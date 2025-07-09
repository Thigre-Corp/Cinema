<?php

namespace Controller; //espace virtuel
use Model\Connect;

class FilmController {

//récupérer les infos nécessaires à la vue modFilm
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

//update de l'affiche
    public function updateAffiche($id, $filteredPost){
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

//update de la note
    public function updateNote($id, $filteredPost){
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

//update du titre    
    public function updateTitre($id, $filteredPost){
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

//update de l'année de sortie    
    public function updateAnnee($id, $filteredPost){
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

//update de la durée (en mn)
    public function updateDuree($id, $filteredPost){
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

//update de l'ID du Réalisateur
    public function updateReal($id, $filteredPost){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                UPDATE film
                SET id_realisateur = :filteredPost
                WHERE  id_film = :id
            ");
        $requete->execute([
            "id" =>$id , 
            "filteredPost" => $filteredPost
        ]);
       $this::modFilm($id);
    }

//update du Synopsis 
    public function updateResume($id, $filteredPost){
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

//suppression d'un rôle    
    public function updateDeleteRole($id, $filteredActorID, $filteredRoleID){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                DELETE FROM casting
                WHERE id_film = :id AND id_acteur = :filteredActorID AND id_role = :filteredRoleID
            ");
        $requete->execute([
            "id" =>$id ,
            "filteredActorID" => $filteredActorID,
            "filteredRoleID" => $filteredRoleID
        ]);
       $this::modFilm($id);
    }

//Ajout d'un rôle 
    public function updateAddRole($id, $filteredActorID, $filteredRoleID){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                INSERT INTO casting ( id_film, id_role, id_acteur)
                VALUES (:id, :filteredRoleID,  :filteredActorID)
            ");
        $requete->execute([
            "id" =>$id ,
            "filteredActorID" => $filteredActorID,
            "filteredRoleID" => $filteredRoleID
        ]);
       $this::modFilm($id);
    }

//update des genres     
    public function updateGenre($id, $filteredPost){
        $pdo = Connect::seConnecter();
        $requete = $pdo->prepare(
            "
                DELETE FROM appartenir
                WHERE id_film = :id
            ");
        $requete->execute([
            "id" =>$id 
        ]);
        foreach($filteredPost as $genre){
            $requete = $pdo->prepare(
                "
                    INSERT INTO appartenir ( id_film, id_genre)
                    VALUES ( :id , :genre)
                ");
            $requete->execute([
                "id" =>$id,
                "genre" =>$genre 
            ]);
        }
       $this::modFilm($id);
    }
// fin FilmController
}