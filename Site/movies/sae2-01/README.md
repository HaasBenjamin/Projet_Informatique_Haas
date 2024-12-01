# SAE2-01 : Création d'application web : Movies
# Auteurs : 
            - Haas Benjamin
            - Lawson Marc-Aurel 

## Les Classes : 
*   ``Movie`` : Cette classe permet de récupérer les informations d'un film. Cette classe possède:
  1) Tous les attributs,getters et les setters
2) Une méthode findById qui renvoie une instance de Movie correspondant au film qui possède comme id, l'id passé en paramètre
3) Une méthode delete permettant de supprimer un film
4) Une méthode insert permettant d'insérer un nouveau film
5) Une méthode update permettant de modifier un film précis
6) Un constructeur privé
7) Une méthode create qui permet de créer une instance de Movie à partir des paramètres nécessaires
8) Une méthode save qui renvoie à la méthode insert ou update en fonction de la précense ou non d'id
<br><br>
* ``ActorMovies`` : Cette classe permet de récupérer les informations d'un acteur. Cette classe possède : 
  1) Tous les attributs/getters 
  2) Une méthode findById qui renvoie une instance de ActorMovies correspondant à l'acteur qui possède comme id, l'id passé en paramètre
  3) Une méthode getRole qui prend en paramètre l'id d'un film et qui renvoie le rôle de l'acteur dans ce film 
<br><br>  
* ``Gender`` : Cette classe permet de récupérer les informations d'un genre de film. Cette classe possède :
  1) Tous les attributs / getters
  2) Une méthode findById qui renvoie une instance de Gender correspondant au genre qui possède comme id, l'id passé en paramètre
<br><br>
* ``Image`` : Cette classe permet de récupérer les informations d'une image. Cette classe comporte :
  1) Tous les attributs/getters
  2) Une méthode findById qui renvoie une instance de Image correspondant à l'image qui possède comme id, l'id passé en paramètre
<br><br>

## Les collections : 
* ``ActorMoviesCollections`` : Cette classe permet de renvoyer un ensemble d'acteur. Cette classe contient : 
  1) Une méthode findAll qui prends en paramètre l'id d'un film et qui renvoie tous les acteurs ayant participé à ce film
<br><br>
* ``MovieCollection`` : Cette classe permet de renvoyer un ensemble de film. Cette classe contient :
  1) Une méthode findAll qui renvoie l'ensemble des films
  2) Une méthode getMovieByactorId qui prend en paramètre l'id d'un acteur et qui renvoie tous les films dans lequel apparaît cette acteur
<br><br>
* ``GenderMoviesCollection`` :Cette classe permet de renvoyer un ensemble de genre. Cette classe contient :
  1) Une méthode findAll qui renvoie l'ensemble des genres
  2) Une méthode findAllMoviesByGender qui renvoie tous les films appartenant au genre passé en paramètre

## Les exceptions : 
* ``EntityNotFoundException`` : Exception en cas de réponse vide, en cas d'objet introuvable
* ``ParameterException`` : Exception en cas de problème de paramètre issus des queries string

## La base de donnée : 
* ``MyPdo`` : classe qui hérite de PDO et qui permet de créer un singleton pour se connecter à la base de donnée

## Le formulaire : 
* ``MoviesForm`` : Classe qui créer un formulaire qui servira à modifier ou insérer un film. Cette classe contient : 
  1) Les attributs/Getters
  2) Un constructeur
  3) Une méthode getHtmlForm qui renvoie un formulaire html qui contient tous les éléments d'un film
  4) Une méthode setEntityFromQueryString qui permet de créer une entité à partir des queries string
  
## Les WebPages : classes permettant de créer rapidement et efficacement une page html
* ``WebPage/AppWebPage`` : Différentes fonctions qui permettent de créer une structure html / Ajoute une balise qui contient le titre (AppWebPage)
* ``StringEscaper`` : Classe qui permet de traiter les chaînes de caractères


## Les pages internet 
* ``index`` : Page d'accueil du site -> affiche tous les films, propose un tri sur les films, et une création de film
* ``image`` : Page permettant de renvoyer les images des acteurs ou des films/ renvoyer une image par défaut en cas d'absence d'image
* ``Movies-details`` : Page de présentation d'un film -> affiche une présentation du film et affiche ses acteurs
* ``Actors-details`` : Page de présentation d'un acteur -> affiche une présentation d'un acteur et affiche ses films 

## Les pages de styles
* ``Actors-details`` : Feuille de style de la page Actors-details
* ``Actors-Movies-css`` : Feuille de style de la page Movies-details
* ``form`` : Feuille de style de la page du formulaire
* ``style1`` : Feuille de style de la page index

## Les fichiers de modifications : 
* ``movies-form`` : Créer un formulaire et envoie les réponses au fichiers movies-save.php
* ``movies-save`` : A partir des données récupérés, créer un nouveau film ou modifie le film choisi
* ``movies-delete`` : Permet de supprimer un film et toutes ses dépendances

## Fichiers de lancement du serveur :
* ``run-server.bat`` : Permet de lancer le seveur local sur le port 8000
* ``run-server.sh`` : Permet de lancer le seveur local sur le port 8000

## Autres fichiers :
* ``.mypdo.ini`` : fichier utilisé par la classe MyPdo pour créer la configuration d'accès à la base 
* ``.gitignore`` : fichier permettant d'exclure des fichiers ou dossier du git
* ``php-cs-fixer`` : Permet de vérifier que le fichier est conforme à la norme PSR-12
* ``composer.json`` : fichier de configuration de composer comprends : 
  1) Présentation auteurs/projet
  2) Configuration de l'auto-chargement 
  3) Configuration des require
  4) Différents scripts : 
     1) start:linux : permet de lancer le serveur local sous linux
     2) start:win : permet de lancer le serveur local sous windows
     3) test:cs : permet de lancer la vérification du csfixer 
     4) fix:cs : permet de lancer la correction du cdfixer
     5) start : alias pour le script start:linux
     6) test:Movie : permet de lancer les tests du livrable1
     7) test:Livrable2 : permet de lancer les tests du livrable2 (provoque erreur car mauvaise base de données et solution introuvée)
* ``composer.lock`` : Répertorie la version exact du composer

## Les tests : 
* Livrable 1 : Tests sur toutes les méthodes des classes hormis celles de modification 
* Livrable 2 : Tests sur les méthodes insert/delete/update