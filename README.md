ToDoList
========

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1
=======
[Améliorez une application existante de ToDo &amp; Co](https://openclassrooms.com/projects/ameliorer-un-projet-existant-1)

[![SymfonyInsight](https://insight.symfony.com/projects/58d88bf9-9db3-4f3e-ab42-eedb384ff658/big.svg)](https://insight.symfony.com/projects/58d88bf9-9db3-4f3e-ab42-eedb384ff658/analyses/25)
[![Code Climate](https://codeclimate.com/github/eddesscv/P8-OC-ToDoList.png)](https://codeclimate.com/github/eddesscv/P8-OC-ToDoList)
[![Build Status](https://app.travis-ci.com/eddesscv/P8-OC-ToDoList.svg?branch=master)](https://app.travis-ci.com/eddesscv/P8-OC-ToDoList.svg?branch=master)

## Environnement de développement

- Symfony 5.2.2
- Composer 2.2.5
- ...
- WampServer 3.1.6
  - Apache 2.4.51
  - PHP 7.4.26
  - MySQL 8.0.27

## Installation

Clonez ou téléchargez le repository GitHub dans le dossier voulu :

    https://github.com/eddesscv/P8-TodoList.git

Configurez vos variables d'environnement telles que la connexion à la base de données .env.

Téléchargez et installez les dépendances back-end du projet avec [Composer](https://getcomposer.org/download/) :

    composer install

Créer la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :

    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create

Créez les fixtures vous permettant de tester :

    php bin/console doctrine:fixtures:load
