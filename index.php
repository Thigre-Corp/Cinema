<?php



use Controller\CinemaController;

spl_autoload_register(function ($class_name){
include $class_name . '.php';
});

$ctrlCinema = new CinemaController();

$id = (isset($_GET["id"])) ? $_GET["id"] : null;

if (isset($_GET["action"])){
    switch($_GET["action"]){
        case "listFilms" : $ctrlCinema->listFilms(); break;
        case "listActeurs" : $ctrlCinema->listActeurs(); break;
        case "detailFilm" : $ctrlCinema->detailFilm($id); break;
        default: $ctrlCinema->listFilms();
    }
}
else{
    $ctrlCinema->listFilms(); // besoin de mettre la vue accueil
}