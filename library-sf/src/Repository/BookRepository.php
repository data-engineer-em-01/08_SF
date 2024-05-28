<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function findBooksByMinPrice(float $minPrice)
    {
        return $this->createQueryBuilder('b')
            ->where('b.price > :minPrice')
            ->setParameter('minPrice', $minPrice)
            ->getQuery()
            ->getResult();
    }

    public function findRecentBooks()
    {
        $date = new \DateTime();
        $date->modify('-30 days');

        return $this->createQueryBuilder('b')
            ->where('b.publishedAt >= :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }

    public function findBooksByTitle(string $title)
    {
        return $this->createQueryBuilder('b')
            ->where('LOWER(b.title) LIKE LOWER(:title)')
            ->setParameter('title', '%' . $title . '%')
            ->getQuery()
            ->getSingleResult();
    }

}
