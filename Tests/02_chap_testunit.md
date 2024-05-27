# Test unitaire

## Création d'un test pour tester des méthodes dans un service

```bash
php bin/console make:test

Which test type would you like?:
> TestCase

 The name of the test class (e.g. BlogPostTest):
 > TextTest

```

## Mise en place des tests pour les ripositories

Dans le fichier **.env.local**

```txt
DATABASE_URL="mysql://root:antoine@127.0.0.1:3306/library"
```

Une fois ce fichier renseigner on va travailler avec la base de données de test à savoir library_test, voyez les commandes ci-dessous :

```bash
# Lancé les tests
php bin/phpunit
# Création de la base de données
php bin/console --env=test doctrine:database:create

# Création de/des table(s) dans la base de données
php bin/console --env=test doctrine:schema:create

# load des données dans la/les tables de tests
php bin/console --env=test doctrine:fixtures:load

# La configuration 
composer require --dev dama/doctrine-test-bundle
```

1. Mise en place de la classe de test BookRepositoryTest.
   
   1. Vous devez choisir de prendre le Kernel, voyez l'exemple ci-dessous pour bien commencer, implémentez ce test et vérifiez que tout marche bien.
```php
<?php

namespace App\Tests;

use App\Entity\Book;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookRepositoryTest extends KernelTestCase
{
    // entity manager 
    private ?EntityManager $entityManager;

    // setUp pour configurer l'ajout du container de service
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    // On teste si le prix d'un livre correspond au prix dans la base de données
    public function testPriceOneBookAuthor(): void
    {
        $book = $this->entityManager
            ->getRepository(Book::class)
            ->findOneBy(['author' => 'Heath Jones']);

        $this->assertSame('37.54', $book->getPrice());
    }
}
```

1. Testez maintenant les méthodes suivantes 
   
   1.  `findBooksByMinPrice(float $minPrice)`: Trouver les livres dont le prix est supérieur à un certain montant. Remarques avec une requête classique je trouve 61 books qui dépasse le prix de 30 euros, testez d'abord en pur SQL  `SELECT COUNT(*) FROM book WHERE price > 30`
   2. `findRecentBooks()`: Trouver les livres publiés dans les 30 derniers jours. Faites d'abord la requête puis comparez avec votre test dans la classe de test. Pensez à hydrater vos données avec le faker en place avec la syntaxe suivante afin de pouvoir tester cette méthode `'publishedAt' => self::faker()->dateTimeThisYear('+3 months')`. Faites également la requêtes SQL pour savoir combien vous avez de books qui correpsondent à cette requête : `SELECT COUNT(*) FROM book WHERE published_at >= DATE_SUB(CURDATE(), INTERVAL 30 DAY);`
   3. `findBooksByTitle(string $title)`: Trouver les livres par titre, recherche insensible à la casse.

## Service BookService

1. Création du Service et des ses fonctionnnalités 
    1. calculatePriceWithBonus(float $price, float $bonusPercentage): float
    1. convertEuroToDollar(float $priceInEuro): float
    1. getBooksPriceInDollars(): array