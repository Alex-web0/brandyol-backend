<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductFeatureRequest;
use App\Http\Requests\UpdateProductFeatureRequest;
use App\Http\Resources\ProductFeatureResource;
use App\Models\Product;
use App\Models\ProductFeature;
use App\OpenApi\Parameters\GetProductFeaturesParameters;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\RequestBodies\CreateProductFeatureRequestBody;
use App\OpenApi\RequestBodies\UpdateProductFeatureRequestBody;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\GetProductFeaturesResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\Request;

use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class ProductFeatureController extends Controller
{
    // TODO: annotate default return si 100
    /**
     * Fetch **UP TO 100** product features
     * 
     * Will fetch by default the first 100 product features to display
     */
    #[OA\Operation(tags: ['product-features'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: GetProductFeaturesParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GetProductFeaturesResponse::class, statusCode: 200)]
    public function index(Request $request)
    {
        $request->validate(
            [
                'product_id' => 'nullable|integer',
            ]
        );

        $query = ProductFeature::query();

        if (!empty($request->input('product_id'))) {
            $query = $query->where('product_id', '=', $request->input('product_id'));
        }


        return ProductFeatureResource::collection($query->paginate(
            $request->input('per_page') ?? 100,
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Create a new product feature for a product
     * 
     * Provided a product id, will create a new product feature
     */
    #[OA\Operation(tags: ['product-features'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: CreateProductFeatureRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function store(StoreProductFeatureRequest $request)
    {
        $data = $request->validated();

        $p = Product::findOrFail($data->product_id);

        ProductFeature::create([
            'title' => $data->title,
            'value' => $data->value,
            'product_id' => $p->id,
        ]);

        return response()->json(null);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductFeature $productFeature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductFeature $productFeature)
    {
        //
    }


    /**
     * Updates an existing product feature
     * 
     * Will change product feature data, not product id though
     */
    #[OA\Operation(tags: ['product-features'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: IDPathParameters::class)]
    #[OA\RequestBody(factory: UpdateProductFeatureRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function update($id, UpdateProductFeatureRequest $request, ProductFeature $productFeature)
    {
        // said product feature
        $p = ProductFeature::findOrFail($id);
        $p->update($request->validated());

        return response()->json(null);
    }

    /**
     * Deletes a product feature 
     * 
     */
    #[OA\Operation(tags: ['product-features'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function destroy($id, ProductFeature $productFeature)
    {
        ProductFeature::destroy([$id]);

        return response()->json(null);
    }
}
