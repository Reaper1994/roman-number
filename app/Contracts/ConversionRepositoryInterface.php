<?php

namespace App\Contracts;
interface ConversionRepositoryInterface
{
    public function storeConversion(int $integerValue, string $romanNumeral);
    public function getRecentConversions(int $perPage = 10);
    public function getTopConversions(int $limit = 10);
}
