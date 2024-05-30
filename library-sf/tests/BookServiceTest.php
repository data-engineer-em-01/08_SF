<?php

namespace App\Tests;

use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class BookServiceTest extends KernelTestCase
{
    protected BookService $bookService;
    protected $exChangeRate ;
    protected $roundPrice ;

    protected function setUp(): void
    {
        // le kernel qui contient le conteneur de services
        $kernel = self::bootKernel();
        // instance du conteneur
        $container = self::getContainer();
        // on va chercher le service BookService 
        $this->bookService = $container->get(BookService::class);
        // on récupère la valeur dans le fichier env.test, ça marche parce que exécuté avant chaque test
        $this->exChangeRate = $_ENV['EXCHANGE_RATE'];
    }

    public function testConvertEuroToDollar(): void
    {
        $price = 34.5;
        $this->assertEquals(
            $price * $this->exChangeRate,
            $this->bookService->convertEuroToDollar($price)
        );
    }

    /**
     * @dataProvider pricesProvider
     */
    public function testCalculatePriceWithBonus($price, $bonus, $excped): void
    {
        $this->assertEquals($excped , $this->bookService->calculatePriceWithBonus($price, $bonus));
    }

    public function pricesProvider()
    {
        // attention on doit récupérer la valeur ROUND_PRICE dans env.test car cette méthode n'est pas appelée dans le setUp 
        return [
            [34.5, 10, round( 34.5 * (1 - 0.1), $_ENV['ROUND_PRICE'])],
            [77, 2, round( 77 * (1 - 0.02), $_ENV['ROUND_PRICE'])],
            [200, 5, round( 200 * (1 - 0.05), $_ENV['ROUND_PRICE'])],
            [76, 20, round( 76 * (1 - 0.2), $_ENV['ROUND_PRICE'])],
        ];
    }
}
