<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetReviewsRequest;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\PublicReviewResource;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\OpenApi\Parameters\CreateReviewParameters;
use App\OpenApi\Parameters\GetProductsParameters;
use App\OpenApi\Parameters\GetReviewsParameters;
use App\OpenApi\RequestBodies\CreateReviewRequestBody;
use App\OpenApi\RequestBodies\UpdateReviewRequestBody;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\GetReviewManagementResponse;
use App\OpenApi\Responses\GetReviewResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OA;

use function Illuminate\Log\log;

#[OA\PathItem]
class ReviewController extends Controller
{
    protected function mergeSearchParamsInQuery(Builder $query, GetReviewsRequest $request): Builder
    {

        if (!empty($request->rating)) {
            $query = $query->where('rating', '=', $request->rating);
        }

        if (!empty($request->user_id)) {
            $query = $query->where('user_id', '=', $request->user_id);
        }



        // TODO: complete
        // if (!empty($request->did_buy)) {
        //     $query = $query->with('didBuy')->where('did_buy');
        // }

        $product_id = $request->product_id;

        if (!empty($product_id)) {
            $query = $query->whereHas('product')->whereBelongsTo(
                Product::findOrFail($product_id),
            );
        }

        return $query;
    }

    /**
     * Management Fetch Reviews
     * 
     * Will fetch all reviews paginated (could be filtered for users)
     */
    #[OA\Operation(tags: ['reviews'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: GetReviewsParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GetReviewManagementResponse::class, statusCode: 200)]
    public function index(GetReviewsRequest $request)
    {
        $query = Review::query();

        // with search params
        $query = $this->mergeSearchParamsInQuery($query, $request);

        $query = $query->with([
            // 'didBuy',
            'user',
            'product'
        ])->withCount(['likes as likes']);

        return $query->paginate();
    }


    /**
     * Will fetch all public reviews for users
     * 
     * Will return minimum, redacted data as Public reviews
     * and will account for shadow-banned reviews
     */
    #[OA\Operation(tags: ['reviews'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: GetReviewsParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GetReviewResponse::class, statusCode: 200)]
    public function userListing(GetReviewsRequest $request)
    {
        $requestingUser = $request->user();

        $query = Review::query();

        // with search params
        $query = $this->mergeSearchParamsInQuery($query, $request);

        // add restrictions
        $query = $query
            ->whereBelongsTo(
                User::where('shadow_banned', '!=', true)->orWhere('id', '=', $requestingUser->id)->get()
            )
            // ->withExists('didBuy') // Add an 'did_buy_exists' attribute
            // ->orderBy('did_buy_exists', 'desc') // Order by whether `didBuy` exists
            // ->orderByRaw("id - '$requestingUser->id' ASC") // makes the requesting user review show first
            // eager load USER model on response
            ->with(['user'])
            ->withCount(['likes as likes']);



        return PublicReviewResource::collection($query->paginate(
            $request->input('per_page') ?? 8,
        ));
    }


    /**
     * Add A Review on product
     * 
     * will add a new review
     */
    #[OA\Operation(tags: ['reviews'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: CreateReviewParameters::class)]
    #[OA\RequestBody(factory: CreateReviewRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function store(StoreReviewRequest $request)
    {
        // only the data from the validator
        $data = $request->validated();
        // the product of which we are creating 
        $product_id = $request->product_id;

        // if($request->user()->id == ) {}

        Review::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $product_id,
            ],
            [
                ...$data,
                'user_id' => $request->user()->id,
                'product_id' => $product_id,
            ]
        );
    }


    /**
     * Changes a review's content
     * 
     * Will change the review's content
     */
    #[OA\Operation(tags: ['reviews'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: IDPathParameters::class)]
    #[OA\RequestBody(factory: UpdateReviewRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function update($id, UpdateReviewRequest $request)
    {
        // only updates by passing validated Data
        Review::findOrFail($id)->update($request->validated());
    }



    /**
     * Delete a review
     * 
     * Delete a review of a person or of request-maker
     */
    #[OA\Operation(tags: ['reviews'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function destroy($id, Request $request)
    {
        $review = Review::findOrFail($id);
        $user = $request->user();

        //  check for being admin or resource owner
        if ($request->user()->is_admin_account() || $review->user_id ==  $user) {
            // removes the review
            $review->destroy();
        } else {
            return response()->json(
                [
                    'message' => __('errors.permission_denied')
                ],
                403
            );
        }

        return response()->json(null);
    }
}
