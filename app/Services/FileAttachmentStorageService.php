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
    static public function store($file, int $ownerId, string $ownerType, ?FileAttachment $original = null, $request): FileAttachment
    {
        $path = Helper::upload($file);

        if (empty($original)) {

            return FileAttachment::create(
                [
                    'owner_id' => $ownerId,
                    'path' => $path,
                    'owner_type' => $ownerType,
                    'user_id' => $request->user()->id,
                ],
            );
        } else {

            return FileAttachment::updateOrCreate(
                [
                    'id' => $original->id,
                    'owner_id' => $ownerId,
                    'path' => $path,
                    'owner_type' => $ownerType
                ],
            );
        }
    }


    /*
    @param [string] $newFile : the new file to replace the old one
    @param [int] $id : primary key of model [FileAttachment] to replace the file onto

    @return void
    */
    static public function replaceFile($newFile, $id)
    {
        $current = FileAttachment::findOrFail($id);

        // will throw on addition unsuccessful
        $newUploaded = Helper::upload($newFile);

        // will throw if removal not success
        Helper::removeFileFromStorage($current->path);

        /// completes the update
        $current->update(
            ['path' => $newUploaded]
        );

        return;
    }
}
