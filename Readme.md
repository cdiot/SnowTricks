# Boutique

Il s'agit d'un site communautaire développés avec Symfony.

## Environnement de développement 

### Pré-requis

* PHP 7.4
* MySQL
* Apache
* Composer
* Somfony CLI

Vous pouvez vérifier les pré-requis avec la commande suivante (de la CLI Symfony) :

```bash
symfony check:requirements
```

### Lancer l'environnement de développement 

Pour démarrer l'environnement de développement tapé les commandes suivantes :

```bash
composer install
symfony serve -d
```

Vous pouvez configurer l'accès à la base de données dans le fichier .env