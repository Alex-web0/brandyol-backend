<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
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
use App\Services\PushNotificationService;
use Exception;
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
        return MarketingCampaign::query()->paginate();
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
        $marketingCampaign = $request->validated();

        $image = $request->file('image');
        $type = $marketingCampaign['type'];

        error_log(empty($request->file('image')));

        // enumerate target users query
        $query = User::query()->withCount('orders');

        if (!empty($request->from_date_joined)) {
            $query = $query->where('created_at', '>=', $request->from_date_joined);
        }
        if (!empty($request->to_date_joined)) {
            $query = $query->where('created_at', '<=', $request->to_date_joined);
        }
        if (!empty($request->gender)) {
            $query = $query->where('gender', '=', $request->gender);
        }
        if (!empty($request->from_total_orders)) {
            $query = $query->whereHas(
                'orders',
                function ($query) {},
                '>=',
                $request->from_total_orders
            );
        }
        if (!empty($request->to_total_orders)) {
            $query = $query->whereHas(
                'orders',
                function ($query) {},
                '<=',
                $request->to_total_orders
            );
        }


        // image upload
        $urlOfImage = null;

        if (!empty($image)) {
            $urlOfImage = Helper::getPublicUrl(Helper::upload($image));
        }

        $counterSent = 0;
        $counterFailed = 0;

        // actual sending
        if ($type == 'notification') {
            $resultCollection = $query->get();

            foreach ($resultCollection as $result) {

                try {
                    PushNotificationService::sendPushNotification(
                        $result,
                        $marketingCampaign['title'],
                        $marketingCampaign['body'] ?? '',
                        null,
                        true,
                        (empty($urlOfImage) ? null : $urlOfImage),
                    );
                    $counterSent++;
                } catch (Exception $c) {
                    $counterFailed++;
                    // error_log($c);
                }
            }

            error_log("sent to {$counterSent}, failed {$counterFailed}");
        } else if ($type == 'whatsapp') {
            // TODO: implement what's app sending
            error_log("WHATS APP MESSAGES NOT IMPLEMENTED");
        }

        // store it into the database 
        MarketingCampaign::create([
            ...$marketingCampaign,
            'sent' => $counterSent,
            'failed' => $counterFailed,
            'image_url' => $urlOfImage
        ]);
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
            ->select(User::getExtractableDataArray())
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
