<?php

use Controller\CinemaController;

spl_autoload_register(function ($class_name){
include $class_name . '.php';
}); // charge ttes les classes

$ctrlCinema = new CinemaController();

$id = (isset($_GET["id"])) ? $_GET["id"] : null ; 


if (isset($_GET["action"])){
    switch($_GET["action"]){
        case "listFilms" : $ctrlCinema->listFilms(); break;
        case "listActeurs" : $ctrlCinema->listActeurs(); break;
        case "detailFilm" : $ctrlCinema->detailFilm($id); break;
        case "detailPersonne" : $ctrlCinema->detailPersonne($id); break;
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