# Galerie Theta

## Prérequis

- Apache2
- MariaDB 10.6.12
- PHP 8.2
- Composer 2
- NodeJS LTS 20.11
- NPM 10.2.4

## Installation

1. Importer la base de données.

2. Cloner ce dépôt sur le serveur

3. Changer le paramètre Apache2 DocumentRoot afin qu'il pointe vers le dossier `/public`

4. Installer les dépendances PHP à l'aide de la commande suivante :
    ```shell
    composer install
    ```
5. Installer les dépendances JavaScript
    ```shell
    npm install
    ```