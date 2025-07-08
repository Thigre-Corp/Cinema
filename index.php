<?php

use Controller\CinemaController;

spl_autoload_register(function ($class_name){
include $class_name . '.php';
}); // charge ttes les classes

$ctrlCinema = new CinemaController();

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
            $ctrlCinema->admin(); 
            break;
        case "modFilm":
            $ctrlCinema->modFilm($id);
            break;
        case "updateFilm":
            if( isset($_GET['subForm'])){
                switch($_GET['subForm']){
                    case "affiche":
                        $filteredPost = htmlspecialchars($_POST['filmAffiche']);
                        $ctrlCinema->udAffiche($id, $filteredPost);
                        break;
                    case "note":
                        $filteredPost = intval(htmlspecialchars($_POST['filmNote'])); 
                        $ctrlCinema->udNote($id, $filteredPost);
                        break;
                    case "titre":
                        $filteredPost = htmlspecialchars($_POST['filmTitre']);
                        $ctrlCinema->udTitre($id, $filteredPost);
                        break;
                    case "annee":
                        $filteredPost = intval(htmlspecialchars($_POST['filmAnnee']));
                        $ctrlCinema->udAnnee($id, $filteredPost);
                        break;
                    case "duree":
                        $filteredPost = intval(htmlspecialchars($_POST['filmDuree']));
                        $ctrlCinema->udDuree($id, $filteredPost);
                        break;
                    case "real":
                        $filteredPost = intval(htmlspecialchars($_POST['filmReal']));
                        $ctrlCinema->udReal($id, $filteredPost);
                        break;
                    case "resume":
                        $filteredPost = htmlspecialchars($_POST['filmResume']);
                        $ctrlCinema->udResume($id, $filteredPost);
                        break;
                    case "deleteC":
                        $filteredPost = (explode("*", (array_key_first($_POST)))); // $filteredPost[0] : id rôle, $filteredPost[1] : id acteur
                        $filteredActorID = intval($filteredPost[1]);
                        $filteredRoleID = intval($filteredPost[0]);
                        $ctrlCinema->udDeleteRole($id, $$filteredActorID, $filteredRoleID);
                        break;

                    case "addC":
                        $filteredActorID = intval(htmlspecialchars($_POST['idActeur']));
                        $filteredRoleID = intval(htmlspecialchars($_POST['idRole']));
                        
                    case "genre":
                        var_dump(htmlspecialchars($_POST));
                        aka();

                }
            }
            break;
//administration des Films
        case "adminFilm" : 
            if (isset($_POST['modFilm'])) {
                $filtersArguments = array(
                        'idFilm' => FILTER_VALIDATE_INT,
                        'titreFilm' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'anneeFilm' => FILTER_VALIDATE_INT ,
                        'dureeFilm' => FILTER_VALIDATE_INT ,
                        'noteFilm' => FILTER_VALIDATE_INT ,
                        'afficheFilmURL' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'idReal' => FILTER_VALIDATE_INT,
                        'idGenre' => FILTER_SANITIZE_ENCODED ,
                        'resumeFilm' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'modFilm' => FILTER_SANITIZE_ENCODED,
                        'supprimerFilm' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
                    );
                $filteredPost = filter_input_array(INPUT_POST, $filtersArguments, true);

                if($filteredPost['supprimerFilm'] == 'on'){
                   
                    $ctrlCinema->adminFilm($filteredPost);
                    /*supression du film ...*/
                }
                else{ // modifier film. 

                    $ctrlCinema->adminFilm($filteredPost);
                }
            }
            $ctrlCinema->admin();
            break;
//administration des Genres
        case "adminGenre" :
            if (isset($_POST['modGenre'])) {
                $filtersArguments = array(
                        'idGenre' => FILTER_VALIDATE_INT,
                        'genreLibelle' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'modGenre' => FILTER_SANITIZE_ENCODED,
                        'supprimerGenre' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
                    );
                $filteredPost = filter_input_array(INPUT_POST, $filtersArguments, true);
                $ctrlCinema->adminGenre($filteredPost);
                }
            $ctrlCinema->admin();
            break;
//administration des Personnes
        case "adminPersonne" :
            if (isset($_POST['modPersonne'])) {
                $filtersArguments = array(
                        'idPersonne' => FILTER_VALIDATE_INT,
                        'personneNom' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'personnePrenom' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'personneSexe' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'personneDateNaissance' => FILTER_VALIDATE_INT ,
                        'personnePhotoURL' => FILTER_SANITIZE_FULL_SPECIAL_CHARS ,
                        'modPersonne' => FILTER_SANITIZE_ENCODED,
                        'supprimerPersonne' => FILTER_SANITIZE_FULL_SPECIAL_CHARS, 
                        'estReal' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                        'estActeur' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
                    );
                $filteredPost = filter_input_array(INPUT_POST, $filtersArguments, true);
                $ctrlCinema->adminPersonne($filteredPost);
                }
            $ctrlCinema->admin();
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