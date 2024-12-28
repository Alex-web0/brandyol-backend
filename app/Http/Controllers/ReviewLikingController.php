<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\Review;
use App\OpenApi\Parameters\GetProductsParameters;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\Request;


use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class ReviewLikingController extends Controller
{
    /**
     * Like a Review
     * 
     * Sets the review to like
     */
    #[OA\Operation(tags: ['reviews'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function likeReview($id, Request $request)
    {

        $user = $request->user();
        $review = Review::findOrFail($id);

        // will update if liked already (type is set to 'like' automatically)
        Reaction::updateOrCreate([
            'review_id' => $review->id,
            'user_id' => $user->id,
        ], [
            'review_id' => $review->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Unlike a Review
     * 
     * Sets the review to un-liked
     */
    #[OA\Operation(tags: ['reviews'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function unlikeReview($id, Request $request)
    {

        $user = $request->user();
        $review = Review::findOrFail($id);

        // delete all records of the user id being present
        $review->likes()->where('user_id', '=', $user->id)->delete();

        return;
    }
}
