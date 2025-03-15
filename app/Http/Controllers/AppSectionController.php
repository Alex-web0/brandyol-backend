<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppSectionRequest;
use App\Http\Requests\UpdateAppSectionRequest;
use App\Models\AppSection;
use App\OpenApi\Parameters\GetAppSectionsParameters;
use App\OpenApi\Parameters\GetBrandsParameters;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\RequestBodies\CreateAppSectionRequestBody;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\GetAppSectionsResponse;
use App\OpenApi\Responses\GetBrandsResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OA;



#[OA\PathItem]
class AppSectionController extends Controller
{
    /**
     * List all app_sections
     *
     * paginated list of all app_sections
     */
    #[OA\Operation(tags: ['app_sections'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: GetAppSectionsParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GetAppSectionsResponse::class, statusCode: 200)]
    public function index(Request $request)
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
     * Create a new app_sections
     *
     * Add a app_sections
     */
    #[OA\Operation(tags: ['app_sections'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: CreateAppSectionRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function store(StoreAppSectionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AppSection $appSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AppSection $appSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppSectionRequest $request, AppSection $appSection)
    {
        //
    }

    /**
     * Remove app_sections
     *
     * remove a specified app_sections
     */
    #[OA\Operation(tags: ['app_sections'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function destroy($id, AppSection $appSection)
    {
        //
    }
}
