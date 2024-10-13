<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\PasswordLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\OpenApi\RequestBodies\PasswordLoginRequestBody;
use App\OpenApi\RequestBodies\UserRegisterRequestBody;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\PasswordLoginResponse;
use App\OpenApi\Responses\UserMeResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;

use Vyuldashev\LaravelOpenApi\Attributes as OA;



#[OA\PathItem]
class AuthController extends Controller
{
    static protected $test_numbers = [
        '+9647731001529',
        '+9647701001000',
    ];

    /**
     * Authenticate user.
     *
     * Authenticate by otp for user login.
     */
    #[OA\Operation(tags: ['user'], method: 'POST')]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: PasswordLoginResponse::class, statusCode: 200)]
    public function otpLogin(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'otp' => 'required|numeric|string|min:6,max:6',
        ]);

        /// formatted NUMBER (else an exception is thrown)
        $phoneNumber = Helper::formatPhoneNumber($request->phone_number);




        $idToken = $request->input('id_token');

        // Initialize Firebase
        // $auth = (new Factory)
        //     ->withServiceAccount(__DIR__ . '/../../../config/firebase-config.json')
        //     ->createAuth();

        try {
            // Send OTP
            // $verifiedDecodedIdToken = $auth->verifyIdToken($idToken);
            // dd($verifiedDecodedIdToken->claims());

            // if ($verifiedDecodedIdToken != $auth->getUserByPhoneNumber($phoneNumber)) {
            //     return response()->json([
            //         'message' => 'The uid token sent does not match'
            //     ], 500);
            // }


            $user = User::where('phone_number', '=', $phoneNumber)->get()->first();


            /// CHECK if user exists
            if (empty($user)) {
                return response()->json(
                    // TODO: never ever change this response
                    [
                        'message' => 'You need to register first'
                    ],
                    302,
                );
            }



            /// check user is a customer as they are only allowed to use otp login
            if (!$user->is_customer_account()) {
                return response()->json(
                    [
                        'message' => 'can not login with otp if not a customer'
                    ],
                    403,
                );
            }


            /*======== START AUGMENTED AUTH ========*/
            // TODO: REMOVE ON PRODUCTION
            if (in_array($phoneNumber, $this->test_numbers) && $request->otp == '123123') {
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->plainTextToken;

                return response()->json(
                    [
                        'accessToken' => $token,
                        'token_type' => 'Bearer',
                    ],
                    200,
                );
            }
            /*======== END AUGMENTED AUTH ========*/

            // T O D O: Verify OTP here

            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'accessToken' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }



    /**
     * Authenticate staff member.
     *
     * Authenticate password for staff login.
     */
    #[OA\Operation(tags: ['staff'], method: 'POST')]
    #[OA\RequestBody(PasswordLoginRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: PasswordLoginResponse::class, statusCode: 200)]
    public function login(PasswordLoginRequest $request)
    {
        $phoneNumber = Helper::formatPhoneNumber($request->phone_number);


        try {
            $user = User::where('phone_number', '=', $phoneNumber)->get()->first();

            /// user not existent
            if (empty($user)) {
                return response()->json(
                    [
                        'message' => 'user does not exist'
                    ],
                    404
                );
            }

            /// check user is a customer as they are only allowed to use otp login
            if ($user->is_customer_account()) {
                return response()->json(
                    [
                        'message' => 'can not login with password if a customer'
                    ],
                    403,
                );
            }

            /// Login attempt
            $credentials = [
                'phone_number' => $phoneNumber,
                'password' => $request->password,
            ];

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            }

            $tokenResult = $user->createToken('Personal Access Token');

            $token = $tokenResult->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } catch (\Exception $e) {
            error_log($e);
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }





    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    #[OA\Operation(tags: ['user'], security: BearerTokenSecurityScheme::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: UserMeResponse::class, statusCode: 200)]
    public function user(Request $request)
    {
        $user = $request->user();

        return new UserResource($user);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    #[OA\Operation(tags: ['user'], security: BearerTokenSecurityScheme::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: UserMeResponse::class, statusCode: 200)]
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }



    /**
     * Register a new user
     *
     * Creates a new user if not existing
     */
    #[OA\Operation(tags: ['user'])]
    #[OA\RequestBody(UserRegisterRequestBody::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: UserMeResponse::class, statusCode: 200)]
    public function register(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|unique:users',
            'full_name' => 'required|string',
            'gender' => 'required|string|in:male,female,other',
            'otp_method' => 'required|string|in:whatsapp,sms'
            // 'country_id' => 'required|int',
            // 'state_id' => 'required|int',
            // 'sector' => 'required|string',
            // 'address' => 'required|string',
            // 'id_token' => 'required',

        ]);



        $phone_formatted = Helper::formatPhoneNumber($request->phone_number);



        $idToken = $request->id_token;

        // Initialize Firebase
        $auth = (new Factory)
            ->withServiceAccount(__DIR__ . '/../../../config/firebase-config.json')
            ->createAuth();

        try {
            // Send OTP
            $auth->verifyIdToken($idToken);


            $user = new User([
                'phone_number'  => $phone_formatted,
                'full_name' => $request->full_name,
                'country_id' => $request->country_id,
                'state_id' => $request->state_id,
                'sector' => $request->sector,
                'address' => $request->address,
                'role' => 'customer'
            ]);

            if ($user->save()) {
                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->plainTextToken;

                return response()->json([
                    'message' => 'Successfully created user!',
                    'accessToken' => $token,
                ], 201);
            } else {
                return response()->json(['error' => 'Provide proper details']);
            }


            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'accessToken' => $token,
                'token_type' => 'Bearer',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }


    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
}
