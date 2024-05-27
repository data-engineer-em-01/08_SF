# Correction

1. Installation 
   
```bash
symfony new library 

# pensez à configurer le point .env pour vous connecter à la BD
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle

# création de la base de données
php bin/console doctrine:database:create

# Création de l'entité Book
php bin/console make:entity
# Création de la migration le fichier SQL construit à partir de/des entité(s)
php bin/console make:migration

# la création de/des table(s) dans la base de données
php bin/console doctrine:migrations:migrate

# Les fakers données d'exemples
composer require zenstruck/foundry --dev
# Création du Faker
php bin/console make:factory

# Création de la fixture pour créer les données effectives dans la BD
# Installation des fixtures
composer require --dev orm-fixtures

# load des données
php bin/console doctrine:fixtures:load

# tests
composer require --dev symfony/test-pack
# Lancé les tests
php bin/phpunit
# Création de la base de données
php bin/console --env=test doctrine:database:create

# Création de/des table(s) dans la base de données
php bin/console --env=test doctrine:schema:create

# La configuration 
composer require --dev dama/doctrine-test-bundle
```

- 