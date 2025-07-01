<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <title><?= $titre ?></title>
</head>
<body>
    <div class="container">
        <header>
            <img alt="Logo Drive-in dans un style neon" src="./public/img/DRIVE-IN.png"> 
            <nav>
                <ul>
                    <li class="button nav">FILMS</li>
                    <li class="button nav">REALISATEURS</li>
                    <li class="button nav">ACTEURS</li>
                    <li class="button nav">ADMIN</li>
                </ul>
            </nav>
        </header>
    <nav>
    </nav>
    <main>
        <h1 >PDO Cinema</h1>
        <h2><?= $titre_secondaire ?></h2>
        <?= $contenu ?>
        
    </main>
    <footer>
        <small><a href= "#">Mentions légales, ETC...</a></small>
    </footer>
    </div>
</body>
</html>