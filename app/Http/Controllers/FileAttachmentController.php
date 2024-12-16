<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileAttachmentRequest;
use App\Http\Requests\UpdateFileAttachmentRequest;
use App\Models\FileAttachment;
use App\OpenApi\Parameters\FileAttachmentParameters;
use App\OpenApi\Parameters\IDPathParameters;
use App\OpenApi\RequestBodies\FileCreateRequestBody;
use App\OpenApi\RequestBodies\FileUploadRequestBody;
use App\OpenApi\Responses\CountriesResponse;
use App\OpenApi\Responses\EmptyResponse;
use App\OpenApi\Responses\ErrorUnAuthenticatedResponse;
use App\OpenApi\Responses\ErrorValidationResponse;
use App\OpenApi\Responses\FileAttachmentListingResponse;
use App\OpenApi\Responses\ForbiddenResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\SecuritySchemes\BearerTokenSecurityScheme;
use App\Services\FileAttachmentStorageService;
use Illuminate\Http\Request;
use Vyuldashev\LaravelOpenApi\Attributes as OA;

#[OA\PathItem]
class FileAttachmentController extends Controller
{
    /**
     * Index all files on the server
     */
    #[OA\Operation(tags: ['files'], security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: FileAttachmentParameters::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: FileAttachmentListingResponse::class, statusCode: 200)]
    public function index(Request $request)
    {
        $query = FileAttachment::query();

        if (!empty($request->owner_type)) {
            $query = $query->where('owner_type', '=', $request->owner_type);
        }

        return $query->paginate();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store file on the server
     * 
     * Stores file on server with specific type and owner 
     */
    #[OA\Operation(tags: ['files'],  security: BearerTokenSecurityScheme::class)]
    #[OA\RequestBody(factory: FileCreateRequestBody::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class)]
    public function store(StoreFileAttachmentRequest $request)
    {
        FileAttachmentStorageService::store(
            $request->file('file'),
            $request->owner_id,
            $request->owner_type,
            null,
            $request,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FileAttachment $fileAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FileAttachment $fileAttachment)
    {
        //
    }
    /**
     * Update file on the server
     * 
     * Stores file new on server with specific attachment record 
     */
    #[OA\Operation(tags: ['files'],  security: BearerTokenSecurityScheme::class)]
    #[OA\Parameters(factory: IDPathParameters::class)]
    #[OA\RequestBody(factory: FileUploadRequestBody::class)]
    #[OA\Response(factory: ErrorValidationResponse::class, statusCode: 422)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: ForbiddenResponse::class, statusCode: 403)]
    #[OA\Response(factory: EmptyResponse::class)]
    public function update($id, UpdateFileAttachmentRequest $request, FileAttachment $fileAttachment)
    {

        FileAttachmentStorageService::replaceFile($request->file, $id);
    }

    /**
     * Remove the specified resource from storage.
     * 
     * Remove file from storage
     */
    #[OA\Operation(tags: ['files'], security: BearerTokenSecurityScheme::class)]
    #[OA\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OA\Response(factory: ErrorUnAuthenticatedResponse::class, statusCode: 401)]
    #[OA\Response(factory: EmptyResponse::class, statusCode: 200)]
    public function destroy($id, FileAttachment $fileAttachment)
    {
        (FileAttachment::findOrFail($id))->destroyCompletely();
        return response()->json(null);
    }
}
