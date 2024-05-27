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
            ->findOneBy(['author' => 'Heath Jones']);

        $this->assertSame('37.54', $book->getPrice());
    }
}
