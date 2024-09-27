<?php

namespace App\Http\Controllers;

use App\Http\Requests\BanUserRequest;
use App\Http\Requests\LiftBanUserRequest;
use App\Models\User;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\RequestBodies\BanUserRequestBody;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\Request;

use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class UserBanController extends Controller
{



    /**
     * Ban A User
     *
     * Ban a user from accessing anything with their account
     */
    #[OA\Operation(tags: ['admin', 'bans'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(BanUserRequestBody::class)]
    #[OA\Parameters(IDPathParameters::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function banUser($id, BanUserRequest $request)
    {
        User::findOrFail($id)->update(
            [
                'banned' => true,
                'reason' => $request->reason,
            ]
        );

        return response()->json(null);
    }

    /**
     * Lift ban of A User
     *
     * Lift ban
     */
    #[OA\Operation(tags: ['admin', 'bans'], security: BearerTokenSecurityScheme::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Parameters(IDPathParameters::class)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function liftBan($id, LiftBanUserRequest $request)
    {
        User::findOrFail($id)->update(
            [
                'banned' => null,
                'reason' => null,
            ]
        );

        return response()->json(null);
    }
}
