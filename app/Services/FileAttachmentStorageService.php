<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\FileAttachment;
use Illuminate\Http\Request;

class FileAttachmentStorageService
{
    /*

    @param [string] $ownerType : the ownerType of image to infer relating model
    @param [int] $ownerId : primary key of model [ownerType]
    */
    static public function store($file, int $ownerId, string $ownerType, ?FileAttachment $original = null, $request)
    {
        $path = Helper::upload($file);

        if (empty($original)) {

            FileAttachment::create(
                [
                    'owner_id' => $ownerId,
                    'path' => $path,
                    'owner_type' => $ownerType,
                    'user_id' => $request->user()->id,
                ],
            );
        } else {

            FileAttachment::updateOrCreate(
                [
                    'id' => $original->id,
                    'owner_id' => $ownerId,
                    'path' => $path,
                    'owner_type' => $ownerType
                ],
            );
        }
    }
}
