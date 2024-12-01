<?php

namespace App\Helpers;

use App\Models\PrePaidCard;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelPhone\PhoneNumber;

class Helper
{
    static public function upload($file): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName(); // Generate a unique filename
        $filePath = 'uploads/' . $fileName; // Define the path where the file will be stored in S3
        $didUpload = Storage::disk()->put($filePath, file_get_contents($file), 'private'); // Upload the file
        $urlPath = Storage::disk()->path($filePath); // Get the URL of the uploaded file

        // Optionally, store the file path in your database or return it as a response
        return $urlPath;
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
                500,
            ]
        );
    }
}
