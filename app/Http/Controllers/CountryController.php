<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\OpenApi\Responses\CountriesResponse;
use App\OpenApi\Responses\NotFoundResponse;
use Illuminate\Http\Request;

use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class CountryController extends Controller
{

    /**
     * Get all countries of this app.
     *
     * Get countries.
     */
    #[OA\Operation(tags: ['country'], method: 'GET')]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: CountriesResponse::class, statusCode: 200)]
    public function index()
    {
        return response()->json(
            [
                'data' => Country::all(),
            ]
        );
    }
}
