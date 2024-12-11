<?php

namespace Tests\Unit;

use App\Services\Users\UserNameYear;
use PHPUnit\Framework\TestCase;

class UserNameYearTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_can_concat_year_in_user_name(): void
    {
        $items = [
            'hurtado',
            'garduño',
            'cristian'
        ];

        $userNameYear = new UserNameYear($items);

        $this->assertEquals("HUGAC2024", $userNameYear->makeNameWithYear());
    }
}
