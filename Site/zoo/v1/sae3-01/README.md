<div align="center">
<img src="logo.png" alt="Logo de votre projet" width="480">

# SAE 3.01 : Développement l'application web de gestion d'un zoo : ZooTechPark

[![Symfony Version](https://img.shields.io/badge/Symfony-6.3-brightgreen)](https://symfony.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue)](https://www.php.net/)
[![Doctrine Version](https://img.shields.io/badge/Doctrine-2.16-blue)](https://www.doctrine-project.org/)
[![Codeception](https://img.shields.io/badge/Codeception-^5.0-orange)](https://codeception.com/)
[![PHPUnit](https://img.shields.io/badge/PHPUnit-^9.5-red)](https://phpunit.de/)
</div>

<!-- Menu de Navigation -->

1. [Auteurs](#auteurs)
2. [Présentation du projet](#présentation-du-projet)
3. [Mise en place du projet](#mise-en-place-du-projet)
    - [Installation par Composer](#installation-par-composer)
    - [Configurer PhpStorm](#configurer-phpstorm)
    - [Serveur Web local](#serveur-web-local)
        - [Accès au serveur Web](#accès-au-serveur-web)
4. [Style de codage](#style-de-codage)
5. [Test du code](#test-du-code)
6. [Database](#database)
    - [Configuration](#configuration)
    - [Commande](#commande)
7. [Machine virtuelle](#machine-virtuelle)

---

## 👥 Auteurs :

- GOUEDAR Pierre (goue0015)
- HAAS Benjamin (haas0008)
- LAWSON Marc-Aurel (laws0006)
- LE-GROS Antoine (le-g0067)
- TITEUX Gabriel (tite0002)

---

## 🌐 Présentation du projet :

Le projet d'application web ZooTechPark a comme objectif d’obtenir une solution
de gestion d'un zoo sous la forme d’une application web. Ce projet permet :

- d’identifier le personnel du zoo et les visiteurs du site
- d’ajouter et modifier des animaux (pour le personnel)
- d’ajouter et modifier des enclos (pour le personnel)
- de créer des évéenements et de les modifier (pour le personnel)
- de s’inscrire à un ou plusieurs spectacles (pour les visiteurs)
- de consulter les animaux et enclos...

---

## 🛠️ Mise en place du projet :

### Installation par `Composer`

Lancer installation du projet après le clonage.

```bash 
composer install
``` 

### 🛠️ Configurer PhpStorm

Configurer l'intégration de PHP Coding Standards Fixer dans PhpStorm en fixant le jeu de règles sur `Custom` et en
désignant `.php-cs-fixer.dist.php` comme fichier de configuration de règles de codage.

---

## 🚀 Serveur Web local

Lancez le serveur Web local avec cette commande :<br>
***Attention d'avoir symfony CLI dans votre environment $PATH !***

```bash
composer start
```

### 🌐 Accès au serveur Web

Naviguez alors à partir de cette adresse : <http://127.0.0.1:8000>

**Utilisateur administrateur :**

- `admin@example.com`
- `admin`

---

## 📏 Style de codage

Le code suit la recommandation [Symfony](https://symfony.com/doc/current/contributing/code/standards.html) :

- il peut être contrôlé avec

```bash
composer test:cs
```

- il peut être reformaté automatiquement avec

```bash
composer fix:cs
```

---

## ✔️ Test du code

Le test du code se base sur une db SQLite régénéré à chaque test.<br>
Activé extension : `extension=fileinfo` dans php.ini<br>
Pour déclencher les tests unitaires utilisé :

```bash
composer test:codeception
```

Exécuter tous les tests d'un coup (reformate le code automatiquement)

```bash
composer test
```

---

## 🛢️ Database

### 🛠️ Configuration

Utiliser cette configuration en replacement par votre user et psw dans une copie des `.env` en `.env.local`
`DATABASE_URL=mysql://!user!:!psw!@mysql:3306/!database!?serverVersion=mariadb-10.2.25`

### ⚙️ Commande

Détruit la base de donnée pour la récréée et ajouté des données factices

```bash
composer db
```

---

## 🌐Machine virtuelle

Pour accéder à la machine virtuelle, les identifiants sont :  
- login : "zootechpark".  
- mot de passe : "zootechpark".

Et pour avoir accès à MySQL sur la machine virtuelle, les identifiants sont :
- login : "Root".
- mot de passe : "zootechpark".

### Accès au serveur Web

Naviguez sur le site à partir de cette adresse : <http://10.31.33.46/>

---