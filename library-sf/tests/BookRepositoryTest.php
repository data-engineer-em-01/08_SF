<?php

namespace App\Tests;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManager;

class BookRepositoryTest extends KernelTestCase
{

    // entity manager 
    private ?EntityManager $entityManager;

    // Méthode qui est appelée avant chaque test
    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    // un test 
    public function testPriceOneBookAuthor(): void
    {
        $book = $this->entityManager
            ->getRepository(Book::class)
            ->findOneBy([]);

        $this->assertIsFloat((float) $book->getPrice()  );
    }

    /**
     * Le tests vérifie qu'il y a des livres qui sont supérieur à un prix donné
     */
    public function testFindBooksByMinPrice():void{

        $books = $this->entityManager
        ->getRepository(Book::class)
        ->findBooksByMinPrice(30);

        $this->assertGreaterThan(0, count($books));
    }

    public function testFindRecentBooks():void{

        $books = $this->entityManager
        ->getRepository(Book::class)
        ->findRecentBooks();

        $this->assertGreaterThan(0, count($books));
    }

    public function testFindBooksByTitle():void{

        $title = $this->entityManager
            ->getRepository(Book::class)
            ->findOneBy([])->getTitle();

        $book =  $this->entityManager
        ->getRepository(Book::class)
        ->findOneBy(['title' => strtoupper($title)]);

        $this->assertEquals($title, $book->getTitle() );
    }

}
