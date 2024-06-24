<?php

namespace App\Services\Contracts;

interface IntegerConverterInterface
{
    public function convertInteger(int $integer): string;
}
