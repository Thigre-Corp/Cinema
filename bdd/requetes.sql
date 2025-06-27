--a. Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et réalisateur
SELECT f.film_titre, f.film_annee,  CONVERT(f.film_duree*60 AS TIME) AS duree , p.personne_nom, p.personne_prenom,
FROM film f
INNER JOIN realisateur r
ON f.id_realisateur = r.id_realisateur
LEFT JOIN personne p
ON r.id_realisateur = p.id_personne
WHERE id_film = {id_film}

--b. Liste des films dont la durée excède 2h15 classés par durée (du + long au + court)
SELECT film_titre
FROM film
WHERE flim_duree > 135
ORDER BY film_duree DESC

--c. Liste des films d’un réalisateur (en précisant l’année de sortie)
SELECT f.film_titre, f.film_annee
FROM film f
LEFT JOIN realisateur r
WHERE r.id_realisateur = {id_realisateur}


--d. Nombre de films par genre (classés dans l’ordre décroissant)
SELECT COUNT(f.film), g.genre_libelle
FROM film f
INNER JOIN appartenir a
ON f.id_film = a.id_film
INNER JOIN genre g
ON a.id_genre = g.id_genre
GROUP BY g.genre_libelle

--e. Nombre de films par réalisateur (classés dans l’ordre décroissant)
SELECT COUNT(f.id_film), p.personne_nom
FROM film f
INNER JOIN relarisateur r 
ON f.id_realisateur = r.id_realisateur
INNER JOIN personne p
ON r.id_personne = p.id_personne
GROUP BY p.personne_nom
ORDER BY COUNT(f.id_film) DESC

--f. Casting d’un film en particulier (id_film) : nom, prénom des acteurs + sexe
SELECT p.personne_nom, p.personne_prenom, p.personne_sexe
FROM personne p
INNER JOIN acteur a
ON p.id_personne = a.id_personne
INNER JOIN casting c 
ON a.id_personne = c.id_personne
WHERE c.id_film = {id_film}

--g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de sortie (du film le plus récent au plus ancien)
SELECT ro.role_nom, f.film_annee
FROM role ro 
INNER JOIN casting c 
ON ro.id_role, c.id_role
INNER JOIN acteur a 
ON c.id_personne = a.id_personne
INNER JOIN personne p 
ON a.id_personne = p.id_personne
INNER JOIN film f
ON c.id_film = f.id_film
ORDER BY f.film_annee DESC

--h. Liste des personnes qui sont à la fois acteurs et réalisateurs
SELECT p.personne_nom, p.personne_prenom
FROM personne p 
INNER JOIN acteur a 
ON p.id_personne = a.id_personne
INNER JOIN realisateur r
ON r.id_personne = p.id_personne 
WHERE a.id_personne = r.id_personne

--i. Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien)
SELECT film_titre
FROM film
WHERE DATE_FORMAT(film_annee, %Y) > SUBDATE(NOW()) - INTERVAL 5 YEAR)
ORDER BY film_annee DESC

--j. Nombre d’hommes et de femmes parmi les acteurs
SELECT count(p.personne_sexe), p.personne_sexe
FROM personne p
RIGHT JOIN acteur a
ON a.id_personne = p.id_personne
GROUP BY p.personne_sexe

--k. Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)
SELECT p.personne_nom, p.personne_prenom
FROM personne p 
RIGHT JOIN acteur a 
ON p.id_personne = a.id_personne
WHERE p.personne_dateNaissance >= SUBDATE(NOW()) - INTERVAL 50 YEAR)

--l. Acteurs ayant joué dans 3 films ou plus
SELECT p.personne_nom, p.personne_prenom
FROM personne p
INNER JOIN acteur a 
WHERE p.id_personne = a.id_personne
INNER JOIN casting c 
ON a.id_acteur = c.id_acteur    
WHERE count(c.id_film) >=3;