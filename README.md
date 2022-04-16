# P8-OC-ToDoList!

Base du projet #8 : Améliorez un projet existant
![Sans titre](https://user-images.githubusercontent.com/50627300/158421723-ae54c81e-22e1-4415-ae9f-39f878411a3f.png)


[Améliorez une application existante de ToDo &amp; Co](https://openclassrooms.com/projects/ameliorer-un-projet-existant-1)

[![SymfonyInsight](https://insight.symfony.com/projects/862a5310-cb7c-4ada-9ca9-660d86855bc6/mini.svg)](https://insight.symfony.com/projects/862a5310-cb7c-4ada-9ca9-660d86855bc6/analyses/56)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/6340f1e14ed243fe937065f74e5116b5)](https://www.codacy.com/gh/eddesscv/P8-OC-ToDoList/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=eddesscv/P8-OC-ToDoList&amp;utm_campaign=Badge_Grade)
<a href="https://codeclimate.com/github/eddesscv/P8-OC-ToDoList/maintainability"><img src="https://api.codeclimate.com/v1/badges/4857ec576b6574978d9a/maintainability" /></a>
<a href="https://codeclimate.com/github/eddesscv/P8-OC-ToDoList/test_coverage"><img src="https://api.codeclimate.com/v1/badges/4857ec576b6574978d9a/test_coverage" /></a>

## Environnement de développement
- Symfony 5.2.2
- Composer 2.2.5
- PHPUnit 9.5.20
    - php-code-coverage 9.2.15
- WampServer 3.1.6
    - Apache 2.4.51
    - PHP 7.4.26
    - MySQL 8.0.27


## Installation
Clonez ou téléchargez le repository GitHub dans le dossier voulu :

    https://github.com/eddesscv/P8-OC-ToDoList.git
Configurez vos variables d'environnement telles que la connexion à la base de données .env.

Téléchargez et installez les dépendances back-end du projet avec [Composer](https://getcomposer.org/download/) :

    composer install
Créer la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :

    php bin/console doctrine:database:create
    php bin/console doctrine:schema:create
Créez les fixtures vous permettant de tester :

    php bin/console doctrine:fixtures:load

## Lancer le projet
    symfony server:start

## Authentication

Après avoir lancé les fixtures, vous pouvez utiliser les comptes suivants pour faire le login :

- username: admin
- password: admin

ou

- username: user
- password: user

Pour créer un nouvel user, faire login avec admin.

Les tasks dejà créés sont rattachées à un utilisateur “anonyme”. Vous pouvez créer nouvelles tâches après le login

 ## Tests
    php bin/phpunit ou vendor/bin/phpunit
    
## Génération du rapport de couverture de code :
    vendor/bin/phpunit --coverage-html build/test-coverage

## Pour tester une unité individuelle (example: testIndexWithLogin)
    vendor/bin/phpunit --filter=testIndexWithLogin
    ou
    vendor/bin/phpunit tests/Controller/DefaultControllerTest.php --filter=testIndexWithLogin

L’ensemble des fichiers HTML générés par PHPUnit indiquant le niveau de code coverage de l’application (75 %) est dans le dossier: **/build**

