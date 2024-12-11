<?php

namespace App\Services\Users;

class MakeUserName
{

    /**
     * @param array $items
     */
    public function __construct(private array $items)
    {}

    /**
     * @return string|void
     */
    public function makeName()
    {
        if($this->verifyArray() && $this->verifyEmptyItems() )
            return $this->transformToCapitalLetter($this->playPuzzle());
    }

    public function getChar($item_string, $length): string
    {
        $char = iconv('UTF-8', 'ASCII//TRANSLIT', $item_string);
        $string = preg_replace("/[^a-zA-Z0-9]+/", "", $char);
        return substr($string, 0, $length);
    }

    public function verifyArray():bool
    {
        return is_array($this->items);
    }

    public function verifyEmptyItems(): int
    {
        return count($this->items);
    }

    public function playPuzzle(): string
    {
        $item = '';
        foreach ($this->items as $index => $item_string) {
            if($index < 2) {
                $item .= $this->getChar($item_string, 2);
            } else {
                $item .= $this->getChar($item_string, 1);
            }
        }
        return $item;
    }

    public function transformToCapitalLetter(string $value): string
    {
        return strtoupper($value);
    }
}
