--a. Informations d’un film (id_film) : titre, année, durée (au format HH:MM) et réalisateur
SELECT f.film_titre, f.film_annee,  CONCAT(f.film_duree DIV 60, ':',  MOD(f.film_duree, 60)) AS duree , p.personne_nom, p.personne_prenom,
FROM film f
INNER JOIN realisateur r
ON f.id_realisateur = r.id_realisateur
LEFT JOIN personne p
ON r.id_realisateur = p.id_personne
WHERE id_film = {id_film}

--b. Liste des films dont la durée excède 2h15 classés par durée (du + long au + court)
SELECT f.film_titre
FROM film
WHERE f.flim_duree > 135
ORDER BY f.film_duree DESC

--c. Liste des films d’un réalisateur (en précisant l’année de sortie)




--d. Nombre de films par genre (classés dans l’ordre décroissant)


--e. Nombre de films par réalisateur (classés dans l’ordre décroissant)


--f. Casting d’un film en particulier (id_film) : nom, prénom des acteurs + sexe


--g. Films tournés par un acteur en particulier (id_acteur) avec leur rôle et l’année de sortie (du film le plus récent au plus ancien)


--h. Liste des personnes qui sont à la fois acteurs et réalisateurs


--i. Liste des films qui ont moins de 5 ans (classés du plus récent au plus ancien)


--j. Nombre d’hommes et de femmes parmi les acteurs


--k. Liste des acteurs ayant plus de 50 ans (âge révolu et non révolu)


--l. Acteurs ayant joué dans 3 films ou plus