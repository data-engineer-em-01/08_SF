<?php

namespace App\Tests;

use App\Entity\Book;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookRepositoryTest extends KernelTestCase
{
    private ?EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testPriceOneBookAuthor(): void
    {
        $book = $this->entityManager
            ->getRepository(Book::class)
            ->findOneBy(['author' => 'Hadley Corwin']);

        $this->assertSame('48.35', $book->getPrice());
    }

    public function testFindBooksByMinPrice(): void
    {
        $books = $this->entityManager
            ->getRepository(Book::class)
            ->findBooksByMinPrice(30);

        $this->assertSame(72, count($books));
    }

    public function testFindRecentBookse(): void
    {
        $books = $this->entityManager
            ->getRepository(Book::class)
            ->findRecentBooks();

        $this->assertSame(40, count($books));
    }

    public function testFindBooksByTitle(): void
    {
        $books = $this->entityManager
            ->getRepository(Book::class)
            ->findBooksByTitle('Dicta reprehenderit.');

        $this->assertSame(1, count($books));
    }
}
