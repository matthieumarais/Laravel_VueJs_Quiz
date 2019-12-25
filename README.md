## Test Colorado Laravel 6 & Vue js 2 par Matthieu MARAIS

### Description

Création de questionnaires dynamiques :
- BO accessible par authentification
- Créer / éditer / supprimer un questionnaire
- Créer / éditer / supprimer une question
- Ajout de multiple répondants par questionnaire
- Envoi d'un lien unique par mail aux répondants
- Reprise du questionnaire là ou le repondant c'est arrêté
- Blocage du questionnaire après validation du répondant

### Prérequis

##### - PHP >= 7.3

##### - COMPOSER

##### - laravel/installer > = 3.0

##### - NodeJs


### Installation

##### 1. Cloner ou télécharger le dépôt

##### 2. Executer `composer install` depuis l'intérieur du dossier pour télécharger les dépendances PHP.

##### 3. Executer `npm install` ou `yarn` pour télécharger les dépendances JS.

##### 4. Ouvrir le fichier .env pour configurer vos identifiants de base de données & SMTP

##### 5. Executer `php artisan key:generate` depuis votre terminal

##### 6. Executer `php artisan migrate --seed` pour migrer & amorcer la base de données

##### 7. Executer `php artisan serve` depuis votre terminal pour lancer le serveur PHP

##### 8. Executer `npm run watch` depuis un nouveau terminal pour compiler les fichiers sass et js

### Production

##### Executer `npm run production`

##### Bravo. Vous êtes prêt !! HAVE FUN :D
