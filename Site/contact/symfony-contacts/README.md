# Symfony Contacts 
## Auteurs : Haas Benjamin
## Installation/Configuration :
Récupération de symfony :
wget https://get.symfony.com/cli/installer -O - | bash
Création du projet :
symfony --version 6.3 --webapp new symfony-contacts

## Scripts : 
* `test:cs` → Lance la commande de vérification du PHP CS Fixer
* `fix:cs` → Lance la commande de correction du PHP CS Fixer
* `start` → Lance le serveur web de test
* `test:codeception` → Exécute dans l'ordre
  1) nettoie le répertoire _output 
  2) Destruction silencieuse forcée de la base de données 
  3) Création silencieuse de la base de données 
  4) Création silencieuse du schéma de la base de données 
  5) lance les tests de codeception
* `test` → Lance les tests sur le code et ceux de codeception
* `db` → Exécute dans l'ordre :
  1) Destruction forcée de la base de données     
  2) Création de la base de données 
  3) Application des migrations successives sans questions interactives
  4) Génération des données factices sans questions interactives
 
## Configuration de la base de données 
La base de données `Contact` possède  :
1) Un id de type int qui est la clé primaire
2) Un firstname de type string qui correspond au prénom de taille maximale 30
3) Un lastname de type string qui correspond au nom de taille maximale 40
4) Un email de type string de taille maximale 100
5) Un phone de type string de taille maximale 20
6) Un category de type ManyToOne 

La base de données `Category` possède : 
1) Un id de type int qui est la clé primaire 
2) Un name de type string de taille maximale 30
3) Un contacts contenant la liste des contacts

## Authentification    
Pour tester la connexion en tant qu'admin :
- email : root@example.com 
- mot de passe : test

Pour tester la connexion en tant qu'utilisateur :
- email : user@example.com
- mot de passe : test

