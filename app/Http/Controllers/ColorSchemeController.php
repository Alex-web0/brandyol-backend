<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreColorSchemeRequest;
use App\Http\Requests\UpdateColorSchemeRequest;
use App\Http\Resources\ColorSchemeResource;
use App\Models\ColorScheme;
use App\OpenApi\Parameters\GetColorSchemesParameters;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\RequestBodies\CreateColorSchemeRequestBody;
use App\OpenApi\RequestBodies\UpdateColorSchemeRequestBody;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\GetColorSchemesResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class ColorSchemeController extends Controller
{

    /**
     * Fetch all color schemes
     *
     */
    #[OA\Operation(tags: ['color-schemes'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: GetColorSchemesParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: GetColorSchemesResponse::class, statusCode: 200)]
    public function index(Request $request)
    {
        $query = ColorScheme::query();
        if (!empty($request->name)) {
            $query = $query->where('name', 'like', '%' .  $request->name . '%');
        }

        if (!empty($request->color)) {
            $query = $query->where('color', '=',  $request->color);
        }



        return ColorSchemeResource::collection($query->paginate($request->per_page));
    }


    /**
     * Creates a color scheme
     *
     * Color scheme creation
     */
    #[OA\Operation(tags: ['color-schemes'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: CreateColorSchemeRequestBody::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    public function store(StoreColorSchemeRequest $request)
    {
        ColorScheme::create([
            'color' => $request->color,
            'name' => $request->name,
            'name_kr' => $request->name_kr,

        ]);

        return response()->json(null);
    }

    /**
     * Display the specified resource.
     */
    public function show(ColorScheme $colorScheme)
    {
        //
    }

    /**
     * Updates a color scheme
     *
     * Color scheme update
     */
    #[OA\Operation(tags: ['color-schemes'], security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: UpdateColorSchemeRequestBody::class)]
    #[OA\Parameters(IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    public function update($id, UpdateColorSchemeRequest $request, ColorScheme $colorScheme)
    {

        ColorScheme::findOrFail($id)->update(
            [
                'color' => $request->color,
                'name' => $request->name,
                'name_kr' => $request->name_kr,
            ]
        );

        return response()->json(null);
    }

    /**
     * Updates a color scheme
     *
     * Color scheme deletion
     */
    #[OA\Operation(tags: ['color-schemes'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(IDPathParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    public function destroy($id)
    {
        $colorScheme = ColorScheme::findOrFail($id);
        /// if has association with products if any it will fail
        if ($colorScheme->products()->count() > 0) {
            return response(
                [
                    'message' => __('errors.delete_item_with_children'),
                ],
                422
            );
        } else {

            ColorScheme::destroy($colorScheme->id);
        }


        return response()->json(null);
    }
}
