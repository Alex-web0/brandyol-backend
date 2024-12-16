<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\GetAllProductsRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\OpenApi\Parameters\GetProductsParameters;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\RequestBodies\CreateProductRequestBody;
use App\OpenApi\RequestBodies\UpdateProductRequestBody;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\GetProductFeaturesResponse;
use App\OpenApi\Responses\GetProductsResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use App\Services\FileAttachmentStorageService;
use Carbon\Exceptions\Exception as ExceptionsException;
use Exception;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OA;

use function Illuminate\Log\log;

#[OA\PathItem]
class ProductController extends Controller
{
    /**
     * Fetch paginated products listing with given filters
     * 
     * 
     */
    #[OA\Operation(tags: ['products'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: GetProductsParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GetProductsResponse::class, statusCode: 200)]
    public function index(GetAllProductsRequest $request)
    {

        $query = Product::query();

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

        if (!empty($request->cost)) {
            $query = $query->where('cost', '=', $request->cost);
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






        return ProductResource::collection(
            $query->paginate()
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
     * Creates a new product from scratch
     * 
     * Adds a new product to the database might be non-deletable
     */
    #[OA\Operation(tags: ['products'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: CreateProductRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function store(StoreProductRequest $request)
    {
        $d = $request;

        // Upload images first
        $mainImage =       FileAttachmentStorageService::store(
            $d->image,
            0, // means no owner since no owner can have id 0
            Product::$ownerType,
            null,
            $request
        )->id;

        // create instance 
        $product = new  Product(
            [
                'name' => $d->name,
                'name_kr' => $d->name_kr,
                'description' => $d->description,
                'usage' => $d->usage,
                'stock' => $d->stock,
                'price' => $d->price,
                'cost' => $d->cost,
                'discount' => $d->discount,
                'color_scheme_id' => $d->color_scheme_id,
                'brand_id' =>  $d->brand_id,
                'is_available' => $d->is_available == 'true' ? true : false,
                'user_id' => $request->user()->id,
                'file_attachment_id' => $mainImage, // set path

            ]
        );

        $createdSuccess = $product->save();

        if ($createdSuccess) {
            foreach ($d->product_images as $productImage) {
                try {
                    FileAttachmentStorageService::store(
                        $productImage,
                        $product->id,
                        Product::$ownerType,
                        null,
                        $request
                    );
                } catch (Exception) {
                    log('Error on product creation...');
                }
            }
        } else {
            report(new Exception("Cpould not create new product at..\n{$request}"));

            return response([
                'message' => __('errors.creation_failed'),
                500
            ])->json(null);
        }



        return response()->json(null);
    }

    /**
     * Display the specified resource.
     */
    // public function show($id, Product $product)
    // {
    //     return new ProductResource(Product::findOrFail());
    // }



    /**
     * Updates information of a specific product
     * 
     * Adds a new product to the database might be non-deletable
     */
    #[OA\Operation(tags: ['products'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: IDPathParameters::class)]
    #[OA\RequestBody(factory: UpdateProductRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function update($id, UpdateProductRequest $request, Product $product)
    {
        // said product
        $p = Product::findOrFail($id);

        $d = $request;

        // MAYBE USED TO UPDATE MAIN IMAGE
        // Upload images first
        // $mainImage =       FileAttachmentStorageService::store(
        //     $d->image,
        //     0, // means no owner since no owner can have id 0
        //     Product::$ownerType,
        //     null,
        //     $request
        // )->id;

        // create instance 
        $p->update(
            [
                'name' => $d->name,
                'name_kr' => $d->name_kr,
                'description' => $d->description,
                'usage' => $d->usage,
                'stock' => $d->stock,
                'price' => $d->price,
                'cost' => $d->cost,
                'discount' => $d->discount,
                'color_scheme_id' => $d->color_scheme_id,
                'brand_id' =>  $d->brand_id,
                'is_available' => $d->is_available == 'true' ? true : false,
                // 'file_attachment_id' => $mainImage, // set path
            ]
        );


        return response()->json(null);
    }

    /**
     * removes a product from storage
     * 
     * Adds a new product to the database might be non-deletable
     */
    #[OA\Operation(tags: ['products'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function destroy($id, Product $product)
    {
        return Helper::responseNotImplemented();
    }
}
