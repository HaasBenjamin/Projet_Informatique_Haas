# SAÉ 4.01 - Développement d’une application complexe

[![Symfony Version](https://img.shields.io/badge/Symfony-6.3-brightgreen)](https://symfony.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)](https://www.php.net/)
[![Doctrine Version](https://img.shields.io/badge/Doctrine-2.16-blue)](https://www.doctrine-project.org/)
[![Codeception](https://img.shields.io/badge/Codeception-^5.0-orange)](https://codeception.com/)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-^9.5-red)](https://phpunit.de/)
[![API Platform](https://img.shields.io/badge/APIplateform-3.2-purple)](https://api-platform.com/)

1. [Auteurs](#auteurs)
2. [Présentation du projet](#présentation du projet)
3. [Déploiement](#Déploiement)
4. [Mise en place du projet](#mise en place du projet)
5. Mise en place du projet (avec composer):
    - [Installation par composer](#installation par composer)
    - [Configuration PhpStorm](#configuration de phpstorm)
    - [Serveur web local](#serveur weeb local)
        - [Accès au serveur web](#accès au serveur web)
6. [Style de codage](#style de codage)
7. [Test du code](#test du code)
8. [Base de données](#database)
    - [Configuration](#configuration)
    - [Commande](#commande)

---

## 👥 Auteurs :

* GOUEDAR Pierre (goue0015)
* HAAS Benjamin (haas0008)
* LAWSON Marc-Aurel (laws0006)
* LE-GROS Antoine (le-g0067)
* TITEUX Gabriel (tite0002)

---

## 🌐 Présentation du projet :

Le projet d'application web ZooTechPark a comme objectif d’obtenir une solution
de gestion d'un zoo sous la forme d’une application web. Ce projet permet :

* d’identifier le personnel du zoo et les visiteurs du site
* d’ajouter et modifier des animaux (pour le personnel)
* d’ajouter et modifier des enclos (pour le personnel)
* de créer des évènements et de les modifier (pour le personnel)
* de s’inscrire à un ou plusieurs spectacles (pour les visiteurs)
* de consulter les animaux et enclos...

## 🚀 Déploiement

Dans notre cas, le projet est déjà déployé (vous pouvez retrouver les mêmes consignes utilisées pour le déploiement dans
la sous-partie suivante).

Pour accéder :

- au site web : [https://10.31.33.187/](https://10.31.33.187/)
- à l'API : [https://10.31.33.187/api](https://10.31.33.187/api)
- à Traefik : [http://10.31.33.187:8080/](http://10.31.33.187:8080/)

Pour vous authentifier sur le site en tant qu'administrateur, utilisez :

- Login : **admin@example.com**
- Mot de passe : **admin**

Pour la VM utilisée : `ssh zoo@10.31.33.187` avec le mot de passe **belgique**

### Auto-Déploiement

Pour déployer l'application backend et frontend et les faire fonctionner correctement, veuillez suivre ces étapes
attentivement :

1. Choisissez dans le dossier **Roll-out**, dans la partie backend ou frontend de votre choix, le fichier
   **docker-compose** (les fichiers sont les mêmes peu importe la partie front ou back)
   correspondant à la version souhaitée (***avec ou sans Traefik***), ainsi que le fichier **.env**, et copiez-les dans
   le dossier racine où se trouvera votre projet.

2. Clonez les deux dépôts (**frontend et backend**) dans le même dossier où se
   trouvent vos fichiers **docker-compose** et **.env**.
   Assurez-vous que l'arborescence ressemble à ceci :

```text
Dossier du projet
│
├── Docker-compose.yaml
├── .env
├── Projet Front/
│   ├── ... (contenu du projet frontend)
│
└── Projet Back/
    ├── ... (contenu du projet backend)
```

4. Configurez les fichiers **.env** et **docker-compose** conformément à votre configuration. Dans ce projet, la
   configuration
   est prévue pour fonctionner sur notre VM (adresse IP **10.31.33.187**). Vous devrez adapter cette adresse IP dans les
   fichiers mentionnés précédemment.

5. Pour remplir la base de données, dans le même dossier, exécutez :

```shell
docker run --rm --network=serveur_zoo_production -v ./sae4-01-api/docker:/request mariadb:10.2.25 sh -c "mysql -h db -u demo_prod --password=MySuperPassw0rd sae_s4 < /request/dump.sql"
```

---

## 🛠️ Mise en place du projet (avec docker):

### Modification des variables d'envrionnement :

Pour construire les images nécessaires au déploiement de l'API de l'application ZooTechPark à l'aide de Docker, vous
devez remplacer les valeurs des variables d'environnement présentes dans le fichier `.env`.

Modifiez la section `PHP_IMAGE` et `NGINX_IMAGE` et remplacez `!your_username!` par votre nom d'utilisateur. Vous pouvez
également modifier les autres valeurs si vous le souhaitez.

### Construction des images Docker et déploiment de la pile applicative:

Si vous souhaitez construire et déployer l'API de l'application ZooTechPark, lancer la commande suivante pour donner les
permissions nécessaires à docker sur vos fichiers :

```shell
. permission.sh
```

Ensuite, lancer le script suivant pour automatiser la construction, le déploiement et l'ajout de données pour l'API de
l'application ZooTechPark :

```shell
. docker-build.sh
```

Vous pourrez ensuite accéder à l'API via le lien `localhost:8080/api`.

## 🛠️ Mise en place du projet (avec composer):

### Installation par `Composer`

Pour lancer l'installation du projet après clonage du dépot.

````shell
composer install 
````

### 🛠️ Configurer PhpStorm

Configurez l'intégration de Php Coding Standards Fixer dans PhpStorm
en fixant le jeu de régles sur `Custom` tout en désignant `.php-cs-fixer.dist.php`
comme fichier de configuration de règles de codage.

---

## 🚀 Serveur Web local

Lancez le serveur Web local avec cette commande :<br>
***Attention, il faut avoir symfony CLI dans votre environment $PATH !***

````shell
composer start
````

### 🌐 Accès au serveur Web

Naviguez alors à partir de cette adresse :<http://127.0.0.1:8000>   
Naviguez sur cette addresse <http://127.0.0.1:8000/api>, pour consulter l'interface web Api

## 📏 Style de codage

Le code suit la recommandation [Symfony](https://symfony.com/doc/current/contributing/code/standards.html) :

- il peut être contrôlé avec le script

```shell
composer test:cs
```

- il peut être reformaté automatiquement avec le script

```shell
composer fix:cs
```

---

## ✔️ Test du code

Le test du code se base sur une db SQLite regénéré à chaque test.<br>
Il faut activer l'extension : `extension=fileinfo` dans php.ini<br>
Pour déclencher les tests unitaires, il faut utiliser cet ensemble de script :

```shell
composer test:codeception
```

Pour exécuter tous les tests d'un coup (reformate le code automatiquement)

```bash
composer test
```

---

## 🛢️ Database

### 🛠️ Configuration

Utiliser cette configuration en replacement par votre nom d'utilisateur et mot de passe dans une copie du fichier `.env`
en `.env.local`
`DATABASE_URL=mysql://!user!:!psw!@mysql:3306/!database!?serverVersion=mariadb-10.2.25`

### ⚙️ Commande

Afin de faire des tests,il faut partir d'une base saine le commande suivante permet de supprimer la base de donnée pour
en créer une nouvelle et ajouté des données factices

```bash
composer db
```


    