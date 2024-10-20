<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreColorSchemeRequest;
use App\Http\Requests\UpdateColorSchemeRequest;
use App\Models\ColorScheme;
use App\OpenApi\RequestBodies\StartCampaignRequestBody;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class ColorSchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Creates a color scheme
     *
     * Color scheme creation
     */
    #[OA\Operation(tags: ['campaigns'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: StartCampaignRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    public function store(StoreColorSchemeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ColorScheme $colorScheme)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateColorSchemeRequest $request, ColorScheme $colorScheme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ColorScheme $colorScheme)
    {
        //
    }
}
