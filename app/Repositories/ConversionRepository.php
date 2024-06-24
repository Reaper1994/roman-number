<?php
namespace App\Repositories;

use App\Http\Resources\v1\ConversionCollection;
use App\Http\Resources\v1\TopConversionCollection;
use App\Models\Conversion;
use App\Contracts\ConversionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ConversionRepository implements ConversionRepositoryInterface
{
    public function storeConversion(int $integerValue, string $romanNumeral)
    {
        return Conversion::create([
            'integer_value' => $integerValue,
            'roman_numeral' => $romanNumeral,
        ]);
    }

    public function getRecentConversions(int $perPage = 10): ConversionCollection
    {
        // Retrieve paginated results ordered by 'created_at' descending
        $conversions = Conversion::orderBy('created_at', 'desc')->paginate($perPage);

        return new ConversionCollection($conversions);
    }

    public function getTopConversions(int $limit = 10): TopConversionCollection
    {
        $conversions = Conversion::selectRaw('integer_value, COUNT(*) as count')
            ->groupBy('integer_value')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();

        return new TopConversionCollection($conversions);
    }
}
