<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExtractUserDataRequest;
use App\Http\Requests\StoreMarketingCampaignRequest;
use App\Http\Requests\UpdateMarketingCampaignRequest;
use App\Models\MarketingCampaign;
use App\Models\User;
use App\OpenApi\Parameters\PaginationParameters;
use App\OpenApi\RequestBodies\StartCampaignRequestBody;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\GetCampaignsResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\Response;
use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class MarketingCampaignController extends Controller
{
    /**
     * Get Paginated marketing campaigns 
     *
     * past campaigns
     */
    #[OA\Operation(tags: ['campaigns'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: PaginationParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GetCampaignsResponse::class, statusCode: 200)]
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
    public function store(StoreMarketingCampaignRequest $request)
    {

        // store it into the database 
        MarketingCampaign::create(($request->validated()));
        return response()->json(null);
        // see how to send notification here 
        // TODO: https://stackoverflow.com/questions/37490629/firebase-send-notification-with-rest-api
    }

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


    /**
     * Get And Extract User Data
     *
     * Data extract
     */
    #[OA\Operation(tags: ['campaigns'], security: BearerTokenSecurityScheme::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    // #[OA\Response(factory: GetCampaignsDataResponse::class, statusCode: 200)]
    public function extractUserData(ExtractUserDataRequest $request)
    {
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=userdata.csv',
            'Expires'             => '0',
            'Pragma'              => 'public'
        ];

        $list = User::where('role', '=', 'customer')
            ->withCount('orders', 'reviews')
            ->get()
            ->toArray();

        # add headers for each column in the CSV download
        // array_unshift($list, );

        $csvFile = fopen('userdata.csv', 'w');
        fputcsv($csvFile, array_keys($list[0]));

        foreach ($list as $row) {
            fputcsv($csvFile, (array) $row);
        }

        fclose($csvFile);

        // Download the CSV file
        return response()->download(public_path('userdata.csv'), 'userdata.csv', $headers)->deleteFileAfterSend(true);

        // return response($list, 200, $headers);
    }
}
