# Introduction aux Tests en PHP avec Doctrine

Les tests sont essentiels pour garantir la fiabilité et la stabilité de votre application. Dans le contexte de l'utilisation de Doctrine pour la gestion des données, il est important de comprendre les différents types de tests que vous pouvez utiliser pour vérifier que votre code fonctionne correctement. Nous allons couvrir trois types de tests : les tests unitaires, les tests d'intégration et les tests applicatifs.

## Types de Tests

1. **Tests Unitaires**
2. **Tests d'Intégration**
3. **Tests Applicatifs**

### Tests Unitaires

Les tests unitaires visent à vérifier le comportement de petites unités de code, comme une seule classe ou une méthode. Ils sont écrits pour tester des composants isolés de votre application sans dépendances extérieures (comme une base de données).

**Exemple : Tester une méthode du repository personnalisé**

```php
// tests/Repository/BookRepositoryTest.php

namespace App\Tests\Repository;

use PHPUnit\Framework\TestCase;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class BookRepositoryTest extends TestCase
{
    private $entityManager;
    private $bookRepository;

    protected function setUp(): void
    {
        $paths = [__DIR__ . '/../../src/Entity'];
        $isDevMode = true;
        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        
        $dbParams = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];
        
        $this->entityManager = EntityManager::create($dbParams, $config);
        $this->bookRepository = new BookRepository($this->entityManager, $this->entityManager->getClassMetadata(Book::class));
    }

    public function testFindBooksByMinPrice()
    {
        // Setup des données de test...
        // Appeler la méthode du repository et vérifier les résultats...
    }

    protected function tearDown(): void
    {
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
```

### Tests d'Intégration

Les tests d'intégration vérifient que plusieurs composants fonctionnent correctement ensemble. Dans le contexte de Doctrine, ils impliquent souvent la vérification de l'interaction entre les entités et la base de données.

**Exemple : Tester l'intégration de l'entité `Book` avec la base de données**

```php
// tests/Integration/BookRepositoryIntegrationTest.php

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Book;
use App\Repository\BookRepository;

class BookRepositoryIntegrationTest extends KernelTestCase
{
    private $entityManager;
    private $bookRepository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = self::$container->get('doctrine')->getManager();
        $this->bookRepository = $this->entityManager->getRepository(Book::class);
    }

    public function testFindBooksByMinPrice()
    {
        // Ajouter des livres à la base de données...
        // Appeler la méthode du repository et vérifier les résultats...
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
```

### Tests Applicatifs

Les tests applicatifs vérifient le comportement de l'application complète. Ils impliquent généralement l'exécution de requêtes HTTP et la vérification des réponses. Ces tests couvrent l'intégration complète de votre application, y compris les contrôleurs, les services et les couches de persistance.

**Exemple : Tester une requête HTTP pour récupérer des livres**

```php
// tests/Application/BookControllerTest.php

namespace App\Tests\Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookControllerTest extends WebTestCase
{
    public function testGetBooksByMinPrice()
    {
        $client = static::createClient();

        $client->request('GET', '/books/min-price/10.0');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $content = json_decode($client->getResponse()->getContent(), true);
        
        $this->assertIsArray($content);
        // Vérifiez d'autres aspects de la réponse comme le nombre de livres, les valeurs, etc.
    }
}
```

## Résumé

Ces trois types de tests vous permettent de couvrir différents aspects de votre application :

- **Tests Unitaires** : Vérifient le comportement des unités de code isolées.
- **Tests d'Intégration** : Vérifient que plusieurs composants fonctionnent correctement ensemble.
- **Tests Applicatifs** : Vérifient le comportement de l'application complète.
