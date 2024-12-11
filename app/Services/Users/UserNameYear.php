<?php

namespace App\Services\Users;

class UserNameYear extends MakeUserName
{
    public function __construct(array $items)
    {
        parent::__construct($items);
    }

    public function makeNameWithYear(): string
    {
        $baseName = $this->makeName();
        if (!$baseName) {
            return '';
        }
        $currentYear = date('Y');
        return $baseName . $currentYear;
    }
}