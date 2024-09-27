<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\StatesResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class StateController extends Controller
{
    /**
     * Get all countries of this app.
     *
     * Get countries.
     */
    #[OA\Operation(tags: ['state'], method: 'GET')]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: StatesResponse::class, statusCode: 200)]
    public function index(Request $request)
    {
        $query = $request->query('name');

        return response()->json(
            [
                'data' => empty($query) ? State::all() : State::where('name', 'like', '%' . $query . '%')->get(),
            ]
        );
    }
}
