<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

use App\Services\Text;

class TextTest extends TestCase
{
    protected $text ;
    protected function setUp(): void
    {
      $this->text = new Text();
    }
    public function testSomething(): void
    {
        $this->assertTrue(true);
    }

    public function testShowMessage():void{
        $this->assertEquals('Hello world!', $this->text->showMessage());
    }
}
