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
            ->findOneBy(['author' => 'Hadley Corwin']);

        $this->assertSame('48.35', $book->getPrice());
    }

    public function testFindBooksByMinPrice():void{

        $books = $this->entityManager
        ->getRepository(Book::class)
        ->findBooksByMinPrice(30);

        $this->assertEquals(72, count($books) );
    }

    public function testFindRecentBooks():void{

        $books = $this->entityManager
        ->getRepository(Book::class)
        ->findRecentBooks();

        $this->assertEquals(40, count($books) );
    }

    public function testFindBooksByTitle():void{

        $title = 'VEL naM veniam.' ;

        $book = $this->entityManager
        ->getRepository(Book::class)
        ->findBooksByTitle($title);

        $this->assertEquals('Vel nam veniam.', $book->getTitle() );
    }

}
