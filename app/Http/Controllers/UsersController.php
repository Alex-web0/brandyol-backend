<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\OpenApi\Parameters\GetAllUsersParameters;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\RequestBodies\AdminPasswordResetRequestBody;
use App\OpenApi\RequestBodies\CreateUserRequestBody;
use App\OpenApi\RequestBodies\GetAllUsersRequestBody;
use App\OpenApi\RequestBodies\UpdateNotificationTokensRequestRequestBody;
use App\OpenApi\RequestBodies\UpdateUserRequestBody;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\GetAllUsersResponse;
use App\OpenApi\Responses\NotificationListingResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Propaganistas\LaravelPhone\PhoneNumber;



use Vyuldashev\LaravelOpenApi\Attributes as OA;



#[OA\PathItem]
class UsersController extends Controller
{



    /**
     * List All Users
     *
     * list all users 
     */
    #[OA\Operation(tags: ['admin'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(GetAllUsersParameters::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GetAllUsersResponse::class, statusCode: 200)]
    public function index(Request $request)
    {

        $phone_number = $request->input('phone_number');
        $full_name = $request->input('full_name');
        $role = $request->input('role');
        $gender = $request->input('gender');
        $accountId = $request->input('id');
        $ordersMoreThan = $request->input('orders_more_than');
        $ordersLessThan = $request->input('orders_less_than');
        // $state_id = $request->input('state_id');

        $query = empty($role)  ? User::query() : ($role == 'staff' ? User::where(
            'role',
            '!=',
            'customer'
        ) : User::where(
            'role',
            '=',
            $role
        ));


        if (!empty($full_name)) {
            $query = $query->where('full_name', 'like', '%' . $full_name . '%');
        }


        if (!empty($phone_number)) {
            $query = $query->where('phone_number',  'like', '%' . $phone_number . '%');
        }

        if (!empty($gender)) {
            $query = $query->where('gender', '=', $gender);
        }

        if (!empty($accountId)) {
            $query = $query->where('id', '=', $accountId);
        }

        if (!empty($ordersMoreThan)) {
            $query = $query->where('id', '=', $accountId);
        }

        if (!empty($ordersLessThan)) {
        }

        $query = $query->withCount(
            [
                'orders' =>
                function (Builder $query) {
                    // if (!empty($ordersLessThan)) {
                    //     $query =  $query->whereHasMany() < $ordersLessThan;
                    // }
                    // if (!empty($ordersLessThan)) {
                    //     $query =  $query->count() < $ordersLessThan;
                    // }
                }
            ]

        );

        // if (!empty($state_id)) {
        //     $query = $query->where('state_id', '=', $state_id);
        // }


        return UserResource::collection($query->paginate($request->input('per_page')));
    }




    /**
     * Create a user account
     *
     * Create staff account
     */
    #[OA\Operation(tags: ['admin'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(CreateUserRequestBody::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function store(StoreUserRequest $request)
    {
        $phone_formatted = Helper::formatPhoneNumber($request->phone_number);



        User::create([
            'phone_number'  => $phone_formatted,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            // 'country_id' => $request->country_id,
            // 'state_id' => $request->state_id,
            // 'sector' => $request->sector,
            // 'address' => $request->address,
            'password' => bcrypt($request->password),
            'role' => $request->role
        ]);

        return response()->json(null);
    }


    /**
     * Update a user account
     *
     * Update the data for a user
     * @param string $id the id of the user
     */
    #[OA\Operation(tags: ['admin'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(UpdateUserRequestBody::class)]
    #[OA\Parameters(IDPathParameters::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function update($id, UpdateUserRequest $request)
    {

        User::find($id)->update([
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'role' => $request->role
        ]);

        return response()->json(null);
    }



    /**
     * Reset the password and log out a staff member
     *
     * Resets password for staff user
     */
    #[OA\Operation(tags: ['admin'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(AdminPasswordResetRequestBody::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function adminPasswordReset(Request $request)
    {
        $request->validate(
            [
                'user_to_reset' => 'required|integer',
                'new_pass' => 'required|string',
            ]
        );


        $user = User::findOrFail($request->user_to_reset);

        if (!$user->is_staff()) {
            return response()->json(
                [
                    'message' => __('auth.can_not_reset_pass')
                ],
                403
            );
        }

        $user->update([
            'password' => bcrypt($request->new_pass),
        ]);

        $user->tokens()->delete();

        return response()->json();
    }




    /**
     * Sets and updates notification tokens
     *
     * Sets notification token/tokens for the registered user
     */
    #[OA\Operation(tags: ['user'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(UpdateNotificationTokensRequestRequestBody::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function updateNotificationToken(Request $request)
    {

        $request->validate(
            [
                'device' => 'required|string|in:android,ios,web',
                'token' => 'required|string',
            ]
        );


        $t = $request->device;
        $token = $request->token;

        $user = $request->user();

        // dd($user);
        if ($t == 'android') {
            $user->update(['android_token' => $token]);
        } else if ($t == 'ios') {
            $user->update(['ios_token' => $token]);
        } else if ($t == 'web') {
            $user->update(['web_token' => $token]);
        }


        return response()->json(null);
    }




    /**
     * Grabs a paginated list of user's notifications
     *
     * Get notifications paginated
     */
    #[OA\Operation(tags: ['user'], security: BearerTokenSecurityScheme::class)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: NotificationListingResponse::class, statusCode: 200)]
    public function notifications(Request $request)
    {
        $user = $request->user();
        $query = User::findOrFail($user->id)->userNotifications();

        return new JsonResource(
            $query->orderBy('created_at', 'desc')->paginate(),
        );
    }
}
