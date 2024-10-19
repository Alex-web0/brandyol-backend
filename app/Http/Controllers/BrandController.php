<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\OpenApi\Parameters\GetBrandsParameters;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\RequestBodies\CreateBrandRequestBody;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\GetBrandsResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use App\Services\FileAttachmentStorageService;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OA;



#[OA\PathItem]
class BrandController extends Controller
{
    /**
     * List all brands
     *
     * paginated list of all brands
     */
    #[OA\Operation(tags: ['brands'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: GetBrandsParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GetBrandsResponse::class, statusCode: 200)]
    public function index(Request $request)
    {
        $query = Brand::query();

        // if(!empty($request->product_count)) {
        //     $query = $query->where()
        // }

        if (!empty($request->name)) {
            $query = $query->where('name', 'like', '%' .  $request->name . '%')->orWhere(
                'name_kr',
                'like',
                '%' .  $request->name . '%'
            );
        }

        if (!empty($request->description)) {
            $query = $query->where('description', 'like', '%' .  $request->description . '%');
        }

        if (!empty($request->from_created_at)) {
            $query = $query->where('from_created_at', '=',  $request->from_created_at);
        }
        if (!empty($request->to_created_at)) {
            $query = $query->where('to_created_at', '=',  $request->to_created_at);
        }

        if (!empty($request->order)) {
            $query = $query->orderBy('updated_at', $request->order);
        }


        return BrandResource::collection($query->paginate($request->per_page ?? 20));
    }



    /**
     * Create a new brand
     *
     * Add a brand
     */
    #[OA\Operation(tags: ['brands'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: CreateBrandRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function store(StoreBrandRequest $request)
    {
        $user = $request->user();

        $model = (new Brand(
            [
                'name' => $request->name,
                'description' => $request->description,
                'name_kr' => $request->name_kr,
                'description' => $request->description,
            ]
        ));

        $saved = $model->save();


        error_log($model->id);
        // IF SAVED
        if ($saved) {
            FileAttachmentStorageService::store(
                $request->image,
                $model->id,
                'brand',
                null,
                $request
            );
        }




        return response()->json(null);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }


    /**
     * Update a brand
     *
     * update a brand
     */
    #[OA\Operation(tags: ['brands'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: CreateBrandRequestBody::class)]
    #[OA\Parameters(IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function update($id, UpdateBrandRequest $request, Brand $brand)
    {

        Brand::findOrFail($id)->update(
            [
                'name' => $request->name,
                'description' => $request->description,
                'name_kr' => $request->name_kr,
            ]
        );

        return response()->json(null);
    }

    /**
     * Remove a brand
     *
     * removes brand
     */
    #[OA\Operation(tags: ['brands'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function destroy(Brand $brand)
    {
        if ($brand->products()->count() > 0) {
            return response('Can not remove item with children', 422);
        }

        Brand::destroy($brand->id);

        return response()->json(null);
    }
}
