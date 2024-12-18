<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAnalyticsRequest;
use App\Http\Requests\StoreAnalyticsRequest;
use App\Http\Requests\UpdateAnalyticsRequest;
use App\Models\Analytics;
use App\OpenApi\Parameters\GetAnalyticsParameters;
use App\OpenApi\Responses\ErrorDateNotLogged;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\GeneralAnalyticsResponse;
use App\OpenApi\Responses\GetProductsResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\Request;


use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class AnalyticsController extends Controller
{
    /**
     * Fetch statistics
     * 
     * Will grab statistics and for start and end time if specified 
     */
    #[OA\Operation(tags: ['analytics'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: GetAnalyticsParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GeneralAnalyticsResponse::class, statusCode: 200)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorDateNotLogged::class, statusCode: 400)]
    public function index(GetAnalyticsRequest $request)
    {

        $queryResult = [];

        // fetch record from nearest date from
        // fetch record from farthest
        // absolute negate results to find the entires made in between dates

        // if only start is given, fetch latest and compare
        // if only end is given, fetch it only with no negation

        $sDate = $request->start_date;
        $eDate = $request->end_date;

        if (!empty($sDate) && !empty($eDate)) {
            $start = Analytics::whereDate('created_at', $sDate)->get()->first();
            if (empty($start)) return response()->json(
                ['message' => _('errors.date_not_logged')],
            );


            $end = Analytics::whereDate('created_at', $eDate)->get()->first();
            if (empty($end)) return response()->json(
                ['message' => _('errors.date_not_logged')],
            );

            $queryResult = $end->difference($start);
        } else if (!empty($sDate)) {
            $latestRecord =   Analytics::latest()->first();
            $start = Analytics::whereDate('created_at', $sDate)->get()->first();
            if (empty($start)) return response()->json(
                ['message' => _('errors.date_not_logged')],
            );

            $queryResult = $start->difference($latestRecord);
        } else if (!empty($eDate)) {
            $end = Analytics::whereDate('created_at', $eDate)->get()->first();
            if (empty($end)) return response()->json(
                ['message' => _('errors.date_not_logged')],
            );
            $queryResult = $end;
        } else {
            $queryResult = Analytics::latest()->first();
        }

        return response()->json(
            [
                'data' => $queryResult
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Analytics $analytics)
    {
        //
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Analytics $analytics)
    {
        //
    }
}
