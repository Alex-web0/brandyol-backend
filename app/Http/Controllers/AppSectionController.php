<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreAppSectionRequest;
use App\Http\Requests\UpdateAppSectionRequest;
use App\Http\Resources\AppSectionResource;
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
use App\Services\FileAttachmentStorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
        $query = AppSection::query();


        /// check stuff for params
        if (!empty($request->name)) {
            $query = $query->where('name', 'like', '%' .  $request->name . '%')->orWhere(
                'name_kr',
                'like',
                '%' .  $request->name . '%'
            );
        }
        if (!empty($request->banner_type)) {
            $query = $query->where('banner_type', '=',  $request->banner_type);
        }
        if (!empty($request->section)) {
            $query = $query->where('section', '=',  $request->section);
        }
        if (!empty($request->type)) {
            $query = $query->where('type', '=',  $request->type);
        }






        return AppSectionResource::collection($query->paginate($request->per_page ?? 16));
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
        $file = new AppSection(
            $request->validated()
        );

        $file->save();

        // upload the image
        $imagePath = FileAttachmentStorageService::store(
            $request->image,
            $file->id,
            AppSection::$ownerType,
            null,
            $request
        );


        return response()->json(null);
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
        $current = AppSection::find($id);
        $current->image()?->delete();

        AppSection::destroy([$id]);
    }
}
