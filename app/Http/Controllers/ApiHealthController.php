<?php

namespace App\Http\Controllers;

use App\OpenApi\Responses\ApiHealthResponse;


use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenAPI\PathItem]
class ApiHealthController extends Controller
{
    /**
     * Get API's latest version
     * 
     * Gets the latest version of the API (Based on the OpenAPI specification)
     */
    #[OpenApi\Operation(tags: ['health'])]
    #[OpenApi\Response(factory: ApiHealthResponse::class)]
    public function index()
    {
        // For now we're just returning the version specified in OpenAPI specification (Might change in future)
        return response()->json(['data' => ['version' => config('openapi.collections.default.info.version')]]);
    }
}
