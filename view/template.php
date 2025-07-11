<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./public/css/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

        <title>Drive-In : <?= $titre ?></title>
    </head>
    <body>
        <div class="container">
            <header>
                <img src="./public/img/DRIVE-IN.png" class="imgDriveIn" >
                <h1>Drive-In : <?= $titre ?></h1>
                    
                    <nav>
                        <ul>
                            <li><a class="button accueil" href="./#">ACCEUIL</a></li>
                            <li><a class="button films" href="?action=listFilms">FILMS</a></li>
                            <li><a class="button reals" href="?action=listRealisateurs">REALISATEURS</a></li>
                            <li><a class="button acteurs" href="?action=listActeurs">ACTEURS</a></li>
                            <li><a class="button admin" href="?action=admin">ADMIN</a></li>
                        </ul>
                    </nav>
            </header>
            <main>
                <div id='screen'> <!-- container screen-->
                    <?= $contenu ?>
                </div>
            </main>
            <footer class="footer">
                <small><a href= "#">Mentions légales, ETC...</a></small>
            </footer>
        </div>
    </body>
</html>