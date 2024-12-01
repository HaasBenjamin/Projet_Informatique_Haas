<div align="center">
<img src="public/img/logo.png" alt="Logo de votre projet" width="480">

# SAE 4-REAL-01 -- Développement d’une application complexe -- API PLATFORM -- GESTION D'UN ZOO

[![Symfony Version](https://img.shields.io/badge/Symfony-6.3-brightgreen)](https://symfony.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)](https://www.php.net/)
[![Doctrine Version](https://img.shields.io/badge/Doctrine-2.16-blue)](https://www.doctrine-project.org/)
[![Codeception](https://img.shields.io/badge/Codeception-^5.0-orange)](https://codeception.com/)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-^9.5-red)](https://phpunit.de/)
[![PHPUnit](https://img.shields.io/badge/Docker-^4.5-yellow)](https://www.docker.com/)
[![PHPUnit](https://img.shields.io/badge/REACT-^18-yellow)](https://fr.legacy.reactjs.org/)
</div>

<!-- Menu de Navigation -->

1. [Auteurs](#auteurs)
2. [Présentation du projet](#présentation-du-projet)
3. [Mise en place du projet](#mise-en-place-du-projet)
    - [Installation par npm](#installation-par-npm)
        - [Composants installés](#composants-installés)
    - [Serveur Web local](#🚀-serveur-web-local)
4. [Style de codage](#style-de-codage)

---

## 👥 Auteurs :

- GOUEDAR Pierre (goue0015)
- HAAS Benjamin (haas0008)
- LAWSON Marc-Aurel (laws0006)
- LE-GROS Antoine (le-g0067)
- TITEUX Gabriel (tite0002)

---

## 🌐 Présentation du projet :

### Le projet initial :

Le projet d'application web ZooTechPark a comme objectif d’obtenir une solution de gestion d'un zoo sous la forme d’une
application web. Ce projet permet :

- Identifier le personnel du zoo et les visiteurs du site
- Ajouter et modifier des animaux (pour le personnel et admins)
- Ajouter et modifier des enclos (pour le personnel et admins)
- Créer des événements et de les modifier (pour le personnel et admins)
- S’inscrire à un ou plusieurs spectacles (pour les visiteurs)
- Consulter les animaux et enclos...

### Le projet actuel :

Amélioration du site existant dans le but d'améliorer ergonomie, expérience utilisateur (UX), qualité logicielle,
sécurité, expérience développeur (DX), tests et testabilité. Dans ce but, toutes les données seront adaptés afin d'être
reçu suite à l'interrogation d'une API Web

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

## 🐳 Guide d'utilisation Docker

Ce guide explique comment exécuter ce projet en utilisant Docker, que ce soit en mode développeur ou en mode production.

### Mode Développeur

Pour exécuter le projet en mode développeur, veuillez suivre ces étapes :

1. Assurez-vous d'avoir configuré l'URL de l'API dans le fichier **.env**.
2. Dans le répertoire racine du projet, exécutez la commande suivante :

```shell
docker-compose up
```

Cela permettra de démarrer le projet. Vous pourrez alors modifier le projet et profiter du rechargement à chaud (hot
reload) fourni par Vite. Vos sources seront automatiquement montées en tant que volumes dans le projet, facilitant ainsi
le processus de développement.

### Mode Production

Pour exécuter le projet en mode production, suivez ces étapes :

1. Placez-vous dans le dossier production.

2. Exécutez la commande suivante :

```shell
docker build --tag <NOM>:<VERSION> --target front_nginx --build-arg REACT_APP_API_ENTRYPOINT=<URL-DE-API> ..
```

Assurez-vous d'accorder le fichier **.env** de production avec les valeurs que vous spécifierez dans cette commande.

3. Une fois la construction terminée, exécutez la commande suivante pour lancer le projet en mode production :

```shell
docker-compose up
```

Cela lancera le projet en mode production, prêt à être déployé dans un environnement de production.

---

## 🛠️ Mise en place du projet :

### Installation par `npm`

Installer toutes les dépendances du projet après la récupération du dépôt

```bash 
npm install
``` 

#### Composants installés :

* Outils nécessaires à npm
* Props
* Bootstrap

## 🚀 Serveur Web local

Lancer le serveur web local

```bash
npm run dev
```

## 📏 Style de codage

Le code suit le style de codage d'AirBNB grâce à ESLINT




