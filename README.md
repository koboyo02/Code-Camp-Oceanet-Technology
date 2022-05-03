# Code Camp Oceanet Technology

Pour ce prejet des RH de Oceanet nous ont donner cette problématique ``En tant que responsable des ressources humaines, comment transmettre nos profils techniques en version "anonymisés" ("blindés") à nos clients et prospects IT ?`` pour cela nous avons crée une application web qui permet au candidat de crée le CV dessus et de permettre aux RH d'avoir une parti Admin pour avoir tous les CV en version Blindé et normal.

## Installation

- ``composer install``  installe les dépendances php
- ``npm install``  installe les dépendances javascript
- ``npm run dev`` Lance une build des assets en mode dev

## Lancement 

``php -S localhost:8080 -t public`` lance un serveur php sur le port 8080 en local pointant sur le dossier public

Remarques:

- la configuration des identifiants de la base de données se fait dans le fichier .env
- lors du développement, il est préférable de lancer `npm run dev-server` afin de démarrer un serveur de build qui permet d'éviter de relancer la commande `npm run dev` lors de chaque modification des assets (.js, etc...)

