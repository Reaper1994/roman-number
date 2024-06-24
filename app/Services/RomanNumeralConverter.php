<?php

namespace App\Services;

use App\Enums\RomanNumerals;
use App\Models\Conversion;
use App\Services\Contracts\IntegerConverterInterface;

class RomanNumeralConverter implements IntegerConverterInterface
{

    /**
     * @param int $integer
     * @return string
     */
    public function convertInteger(int $integer):string
    {
        $result = '';

        foreach (RomanNumerals::cases() as $romanNumeral) {

            while ($integer >= $romanNumeral->value) {
                $integer -= $romanNumeral->value;
                $result.= $romanNumeral->name;
            }
        }

        return $result;
    }

}
