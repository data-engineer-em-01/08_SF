<?php

namespace App\Services;
use App\Repository\BookRepository;

class BookService{
    private $bookRepository;
    private $exchangeRate;

    public function __construct(BookRepository $bookRepository, float $exchangeRate)
    {
        $this->bookRepository = $bookRepository;
        $this->exchangeRate = $exchangeRate; 
    }

    /**
     * Calcule un bonus de prix pour un livre.
     *
     * @param float $price Le prix original du livre.
     * @param float $bonusPercentage Le pourcentage du bonus à appliquer.
     * @return float Le prix avec le bonus appliqué.
     */
    public function calculatePriceWithBonus(float $price, float $bonusPercentage): float
    {
        $bonus = round( $price * ($bonusPercentage / 100), 2 ) ;

        return $price + $bonus;
    }

    /**
     * Convertit un prix d'euros en dollars.
     *
     * @param float $priceInEuro Le prix en euros.
     * @return float Le prix en dollars.
     */
    public function convertEuroToDollar(float $priceInEuro): float
    {
        return $priceInEuro * $this->exchangeRate;
    }

    /**
     * Récupère tous les livres avec leur prix converti en dollars.
     *
     * @return array La liste des livres avec les prix en dollars.
     */
    public function getBooksPriceInDollars(): array
    {
        $books = $this->bookRepository->findAll();
        $booksInDollars = [];

        foreach ($books as $book) {
            $priceInDollar = $this->convertEuroToDollar($book->getPrice());
            $booksInDollars[] = [
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'price_in_dollars' => $priceInDollar,
                'published_at' => $book->getPublishedAt(),
            ];
        }

        return $booksInDollars;
    }
}