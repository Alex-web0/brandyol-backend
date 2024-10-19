<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarketingCampaignRequest;
use App\Http\Requests\UpdateMarketingCampaignRequest;
use App\Models\MarketingCampaign;
use App\OpenApi\RequestBodies\StartCampaignRequestBody;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class MarketingCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Create a new marketing campaign
     *
     * Create A Campaign
     */
    #[OA\Operation(tags: ['campaigns'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: StartCampaignRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    public function store(StoreMarketingCampaignRequest $request) {}

    /**
     * Display the specified resource.
     */
    public function show(MarketingCampaign $marketingCampaign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarketingCampaign $marketingCampaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarketingCampaignRequest $request, MarketingCampaign $marketingCampaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketingCampaign $marketingCampaign)
    {
        //
    }
}
