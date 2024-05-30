<?php

namespace App\Tests;

use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookServiceTest extends KernelTestCase
{
    protected BookService $bookService ;
    protected $exChangeRate = 1.1 ;

    protected function setUp(): void
    {
        // le kernel qui contient le conteneur de services
        $kernel = self::bootKernel();
        // instance du conteneur
        $container = self::getContainer();
        // on va chercher le service BookService 
        $this->bookService = $container->get(BookService::class);
    }

    public function testConvertEuroToDollar():void{
        $price = 34.5;
        $this->assertEquals(
            $price * $this->exChangeRate, 
            $this->bookService->convertEuroToDollar($price)
        );
    }

}
