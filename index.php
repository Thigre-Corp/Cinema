<?php

use Controller\CinemaController;
use Controller\FilmController;
use Controller\AdminController;

spl_autoload_register(function ($class_name){
include $class_name . '.php';
}); // charge ttes les classes

$ctrlCinema = new CinemaController();
$ctrlFilm = new FilmController();
$ctrlAdmin = new AdminController();

$id = (isset($_GET["id"])) ? $_GET["id"] : null ; 


if (isset($_GET["action"])){ // keep previous action to get into admin page.
    switch($_GET["action"]){
        case "listFilms" : 
            $ctrlCinema->listFilms(); 
            break;
        case "listActeurs" : 
            $ctrlCinema->listActeurs(); 
            break;
        case "listRealisateurs" : 
            $ctrlCinema->listRealisateurs(); 
            break;        
        case "detailFilm" : 
            $ctrlCinema->detailFilm($id); 
            break;
        case "detailPersonne" :
            $ctrlCinema->detailPersonne($id); 
            break;
        case "admin" :
            $ctrlAdmin->admin(); 
            break;
        case "modFilm":
            $ctrlFilm->modFilm($id);
            break;
        case "updateFilm":
            if(isset($_GET['subForm'])){
                switch($_GET['subForm']){
                    case "affiche":
                        $filteredPost = filter_var($_POST['filmAffiche'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $ctrlFilm->updateAffiche($id, $filteredPost);
                        break;
                    case "note":
                        $filteredPost = filter_var(($_POST['filmNote']), FILTER_VALIDATE_INT); 
                        $ctrlFilm->updateNote($id, $filteredPost);
                        break;
                    case "titre":
                        $filteredPost = filter_var($_POST['filmTitre'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $ctrlFilm->updateTitre($id, $filteredPost);
                        break;
                    case "annee":
                        $filteredPost = filter_var(($_POST['filmAnnee']), FILTER_VALIDATE_INT);
                        $ctrlFilm->updateAnnee($id, $filteredPost);
                        break;
                    case "duree":
                        $filteredPost = filter_var(($_POST['filmDuree']), FILTER_VALIDATE_INT);
                        $ctrlFilm->updateDuree($id, $filteredPost);
                        break;
                    case "real":
                        $filteredPost = filter_var(($_POST['filmReal']), FILTER_VALIDATE_INT);
                        $ctrlFilm->updateReal($id, $filteredPost);
                        break;
                    case "resume":
                        $filteredPost = filter_var($_POST['filmResume'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                        $ctrlFilm->updateResume($id, $filteredPost);
                        break;
                    case "deleteC":
                        $filteredPost = (explode("*", (array_key_first($_POST)))); // $filteredPost[0] : id rôle, $filteredPost[1] : id acteur
                        $filteredActorID = filter_var($filteredPost[1], FILTER_VALIDATE_INT);
                        $filteredRoleID = filter_var($filteredPost[0], FILTER_VALIDATE_INT);
                        $ctrlFilm->updateDeleteRole($id, $filteredActorID, $filteredRoleID);
                        break;
                    case "addC":
                        $filteredActorID = filter_var(($_POST['idActeur']), FILTER_VALIDATE_INT);
                        $filteredRoleID = filter_var(($_POST['idRole']), FILTER_VALIDATE_INT);
                        $ctrlFilm->updateAddRole($id, $filteredActorID, $filteredRoleID);
                        break;
                    case "genre":
                        $filteredPost = filter_var_array(array_keys($_POST), FILTER_VALIDATE_INT);
                        $ctrlFilm->updateGenre($id, $filteredPost);
                        break;
                }
            }
            break;
//administration des Films
        case "addFilm" : 
            if (isset($_POST['addFilm'])) {
                $filtersArguments = array(
                        'idFilm' => FILTER_VALIDATE_INT,
                        'titreFilm' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'anneeFilm' => FILTER_VALIDATE_INT ,
                        'dureeFilm' => FILTER_VALIDATE_INT ,
                        'noteFilm' => FILTER_VALIDATE_INT ,
                        'afficheFilmURL' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'idReal' => FILTER_VALIDATE_INT,
                        'idGenre' => FILTER_VALIDATE_INT ,
                        'resumeFilm' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                    );
                $filteredPost = filter_input_array(INPUT_POST, $filtersArguments, true);
                $ctrlAdmin->addFilm($filteredPost);
            }
            break;
        case "suppFilm" :
            if (isset($_POST['suppFilm'])) {
                $filteredPost = filter_var($_POST['idFilm'], FILTER_VALIDATE_INT);
                $ctrlAdmin->suppFilm($filteredPost);
            }
            break;
//administration des Genres
        case "addGenre" :
            if (isset($_POST['addGenre'])) {
                $filteredPost = filter_var($_POST['genreLibelle'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $ctrlAdmin->addGenre($filteredPost);
            }
            break;
        case "suppGenre" :
            if (isset($_POST['suppGenre'])) {
                $filteredPost = filter_var($_POST['idGenre'], FILTER_VALIDATE_INT);
                $ctrlAdmin->suppGenre($filteredPost);
                }
            break;
//administration des Personnes
        case "addPersonne" :
            if (isset($_POST['addPersonne'])) {
                $filtersArguments = array(
                        'idPersonne' => FILTER_VALIDATE_INT,
                        'personneNom' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'personnePrenom' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'personneSexe' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'personneDateNaissance' => FILTER_VALIDATE_INT , // issue
                        'personnePhotoURL' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'modPersonne' => FILTER_SANITIZE_ENCODED,
                        'supprimerPersonne' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 
                        'estReal' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                        'estActeur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
                    );
                $filteredPost = filter_input_array(INPUT_POST, $filtersArguments, true);
                $ctrlCinema->addPersonne($filteredPost);
            }
            break;
//administration des Rôles
        case "adminRole" :
            if(isset($_POST['modCasting'])){
                // create new cast with id_film, idActeur and idrole
                $ctrlCinema->creerCasting($id, $_POST['idActeur'], $_POST['idRole']);
            }
            else{
                foreach($_POST as $key => $value){
                    if($value == 'Supprimé'){
                        $ctrlCinema->supprimerCasting($id, $key);
                    }
                }
            }
            $ctrlCinema->detailFilm($id);
            break;

//default : retour à l'accueil
        default: $ctrlCinema->accueil(); // retour à l'accueil en cas de valeur non traitée.
    }
}

else{
    $ctrlCinema->accueil();
}


/*utilise objet class PDO pour se interagir avec la BDD (PDO PHP Data Objects), plus large que MySQLi

PDO->query() : requete directe, sans élément variable.
PDO->prepare() ; permet l'insertion de variables dans la requête, qui sera effectif 
    lorsqu'on appelera $..->execute()

query->fetch(): valable pour une requête qui retourne sur une ligne.
query->techAll(): valable pour une requête retournant plusieurs lignes.
    récupère le resultat de la requête dans un tableau associatif -> exploitable ensuite

classe abstraite ?

ob_stat() // ob_clean() - mise en buffer OK

voir try {} ?



















*/