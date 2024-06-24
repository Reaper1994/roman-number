<?php

namespace App\Http\Controllers\Api\v1;

use App\Contracts\ConversionRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\ConvertRequest;
use App\Http\Resources\v1\ConversionCollection;
use App\Http\Resources\v1\ConversionResource;
use App\Http\Resources\v1\TopConversionCollection;
use App\Services\RomanNumeralConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class ConversionController extends Controller
{

    /**
     * @param RomanNumeralConverter $conversionService
     * @param ConversionRepositoryInterface $conversionRepository
     *
     * TODO: Authenticate apis
     */
    public function __construct(
        protected RomanNumeralConverter $conversionService,
        protected ConversionRepositoryInterface $conversionRepository )
    {
        $this->conversionService = $conversionService;
        $this->conversionRepository = $conversionRepository;
    }

    public function convert(ConvertRequest $request): ConversionResource
    {

        $validatedData = $request->validated();

        // Attempt to fetch the cached result first
        $cacheKey = 'roman_numeral_' . $validatedData['integer'];
        $cachedRomanNumeral = Cache::get($cacheKey);

        if ($cachedRomanNumeral) {
            // If cached result exists
            return new ConversionResource($cachedRomanNumeral);
        }
        //else

        $romanNumeral = $this->conversionService->convertInteger(integer: $validatedData['integer']);

         $data = $this->conversionRepository->storeConversion(integerValue: $validatedData['integer'], romanNumeral:$romanNumeral);


        return new ConversionResource($data);
    }

    /*
     * Fetches  10 records per page by default, ordered by 'created_at' descending
     * @param Request $request
     */
    public function recentConversions(Request $request):ConversionCollection
    {
        return $this->conversionRepository->getRecentConversions();
    }

    /*
     * Fetches the top 10  results.
     * @param Request $request
     */
    public function topConversions(Request $request): TopConversionCollection
    {
        return $this->conversionRepository->getTopConversions();
    }

}
