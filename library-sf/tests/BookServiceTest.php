<?php

namespace App\Tests;

use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BookServiceTest extends KernelTestCase
{
    protected BookService $bookService  ;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $container = self::getContainer();
        $this->bookService = $container->get(BookService::class);
    }

    public function testCalculatePriceWithBonus():void{
        $price = 34.5;
        $bonus  = 10 ;
        $this->assertEquals( 
            round( $price * ( 1 - $bonus / 100), 2 )  ,
            $this->bookService->calculatePriceWithBonus($price, $bonus) 
        );
    }


}
