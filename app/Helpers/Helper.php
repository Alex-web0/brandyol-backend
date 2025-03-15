<?php

namespace App\Helpers;

use App\Models\PrePaidCard;
use App\OpenApi\Schemas\ProductSchema;
use Carbon\Carbon;
use Exception;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelPhone\PhoneNumber;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class Helper
{
    static public function upload($file, string $privacy = 'private'): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName(); // Generate a unique filename
        $filePath = 'uploads/' . $fileName; // Define the path where the file will be stored in S3
        $didUpload = Storage::disk()->put($filePath, file_get_contents($file), $privacy ?? 'private'); // Upload the file
        $urlPath = Storage::disk()->path($filePath); // Get the URL of the uploaded file

        // Optionally, store the file path in your database or return it as a response
        return $urlPath;
    }


    /*
        gets a public and hopefully persistant URL of a public file or resource
        using its given path
        [only tested for AWS]
    */
    static public function getPublicUrl(string $path)
    {
        return Storage::disk('s3')->url($path);
    }
    /**
     * Removes a file with path from default storage disk
     * -------------
     * Will throw Exception on any errors
     */
    static public function removeFileFromStorage($path): void
    {
        $didRemove = Storage::disk()->delete($path);

        if (!$didRemove) throw new Exception("Failed to remove file with path {$path} from default storage...");

        return;
    }


    // static public function generateBarcodeNumber(): string
    // {

    //     $characters = '0123456789';
    //     $string = '';

    //     for ($i = 0; $i < PrePaidCard::$barcodeLength; $i++) {
    //         $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    //     }

    //     $ts = str_replace('-', '', Carbon::now()->format('m-d-H-s-Y'));

    //     $string .= $ts;



    //     // call the same function if the barcode exists already
    //     if (Helper::barcodeNumberExists($string)) {
    //         return self::generateBarcodeNumber();
    //     }

    //     // otherwise, it's valid and can be used
    //     return $string;
    // }

    // static public function barcodeNumberExists($number): bool
    // {
    //     // query the database and return a boolean
    //     // for instance, it might look like this in Laravel
    //     return PrePaidCard::where('barcode', '=', $number)->exists();
    // }


    static public function formatPhoneNumber(string $number)
    {
        return (new PhoneNumber($number, config('phone_number.accepted')))->formatE164();
    }


    /// for un-implemented functionality
    static public function responseNotImplemented()
    {
        return response()->json(
            [
                'message' => __('errors.not_implemented'),
            ],
            500
        );
    }



    /// OPEN API
    /*
    * Will merge all properties of given schema instances, MUST BE OF SCHEMA OF OBJECTS
    */
    static public function mergeSchemas(string $object_name = 'body', SchemaFactory ...$schemas)
    {
        $finalContracts = [];

        foreach ($schemas as $s) {
            $finalContracts = [
                ...$finalContracts,
                ...($s)->build()->properties,
            ];
        }

        return Schema::object($object_name)->properties(
            ...$finalContracts
        );
    }

    /// provides the base times and id for response schemas
    static public function baseResponseSchema()
    {
        return [
            Schema::integer('id')->required(),
            Schema::string('created_at')->format(Schema::FORMAT_DATE_TIME)->required(),
            Schema::string('updated_at')->format(Schema::FORMAT_DATE_TIME)->required(),
        ];
    }


    /// Discount 
    static public string $getDiscountValidator = 'numeric|nullable|min:0.0|max:1.0';

    /// Image Place holder
    static public string $placeholderImageUrl = 'https://placehold.co/600x400/EEE/31343C?font=raleway&text=Error';


    /// ============== APP SECTION ==============
    static public function banner_type()
    {
        return Schema::string('banner_type')->enum('carousel_item', 'banner_16_by_19', 'banner_16_by_7', 'banner_square');
    }
    static public function section()
    {
        return Schema::string('section')->enum('default', 'special_offers', 'brands', 'brandyol_special');
    }

    static public function type()
    {
        return Schema::string('type')->enum('brand', 'product', 'url', ' no_action');
    }
}
