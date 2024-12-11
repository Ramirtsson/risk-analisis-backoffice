<?php

namespace Tests\Unit;

use App\Services\Users\MakeUserName;
use PHPUnit\Framework\TestCase;

class MakeUserNameTest extends TestCase
{
    private array $items;

    public MakeUserName $makeUserName;

    private int $charLength;

    public function setUp(): void
    {
        parent::setUp();

        $this->items = [
            'hurtado',
            'garduño',
            'cristian'
        ];

       $this->makeUserName =  new MakeUserName($this->items);
    }

    public function test_can_instance_make_user_name(): void
    {
        $this->assertInstanceOf(MakeUserName::class, $this->makeUserName);
    }

    public function test_can_is_array(): void
    {
        $userName = $this->makeUserName->verifyArray();

        $this->assertTrue($userName);
    }

    public function test_can_verify_empty_array()
    {
        $userName = $this->makeUserName->verifyEmptyItems();
        $itemsCount = count($this->items);
        $this->assertEquals($userName, $itemsCount);
    }

    public function test_can_get_two_letter()
    {
        $this->charLength = 2;
        $userName = $this->makeUserName->getChar($this->items[0], $this->charLength);
        $this->assertEquals(strlen($userName), $this->charLength);
    }

    public function test_can_get_one_letter()
    {
        $this->charLength = 1;
        $userName = $this->makeUserName->getChar($this->items[1], $this->charLength);
        $this->assertEquals(strlen($userName), $this->charLength);
    }

    public function test_can_make_user_name()
    {
        $this->charLength = 5;
        $userName = $this->makeUserName->makeName();
        $this->assertEquals(strlen($userName), $this->charLength);
    }

    public function test_can_capital_letters()
    {
        $name = $this->makeUserName->transformToCapitalLetter($this->makeUserName->makeName());

        $this->assertEquals($name, strtoupper($this->makeUserName->makeName()));
    }
}
