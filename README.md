# CarbuMap ⛽

CarbuMap est une application web réalisée dans le cadre de l'UE **Développement Web** en L2 Informatique à **CY Cergy Paris Université** (2025-2026).

Le site permet de rechercher et comparer les prix des carburants dans les stations-service de France métropolitaine à partir d'une région, d'un département et d'une ville.

## Fonctionnalités

- Carte interactive des régions de France
- Sélection région → département → ville → stations
- Consultation des prix des carburants via l'API publique `data.economie.gouv.fr`
- Filtrage par type de carburant
- Affichage des services proposés par les stations
- Tendances de prix et statistiques de consultation
- Utilisation de plusieurs APIs JSON/XML
- Thèmes jour et nuit mémorisés par cookie
- Mémorisation de la dernière ville consultée
- Interface partiellement bilingue français / anglais

## Technologies utilisées

- **PHP 8**
- **HTML5**
- **CSS3**
- **JavaScript**
- **CSV / JSON / XML**
- **APIs Web**

## Organisation du projet

```text
CarbuMap/
├── api/                 # Appels et traitements liés aux APIs
├── data/                # Données utilisées par l'application
├── images/              # Ressources graphiques
├── includes/            # Éléments PHP réutilisables
├── index.php            # Page d'accueil
├── departement.php      # Recherche par département et ville
├── actualites.php       # Tendances des prix
├── stats.php            # Statistiques de consultation
├── tech.php             # Démonstration des APIs
├── contact.php          # FAQ et présentation du projet
├── plan.php             # Plan du site
├── style-jour.css       # Thème clair
└── style-nuit.css       # Thème sombre
```

## APIs utilisées

- **data.economie.gouv.fr** : prix des carburants
- **ipinfo.io** : géolocalisation par adresse IP
- API Ghibli : exemple d'utilisation d'une API JSON sur la page technique
- API réseau/XML : démonstration d'un traitement XML sur la page technique

## Contexte

Ce projet a été **réalisé en binôme** dans le cadre de la Licence Informatique. Les différentes parties du développement ont été travaillées au cours du projet ; ce dépôt présente la version finale sans attribuer artificiellement chaque fonctionnalité à un seul membre du binôme.

## Auteurs

- **Salma Anoud**
- **Rayan Moulai**
