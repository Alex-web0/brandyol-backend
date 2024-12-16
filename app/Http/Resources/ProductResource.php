<?php

namespace App\Http\Resources;

use App\Helpers\Helper;
use App\Models\FileAttachment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{


    private bool $showOwner;
    private bool $showSales;


    public function __construct($resource, $showOwner = false, $showSales = true)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->showOwner = $showOwner;
        $this->showSales = $showSales;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $showOrders  = false;
        try {
            if ($request->user()->is_staff_account() == true) $showOrders = true;
        } catch (Exception) {
            // do nothing
        }

        return [
            ...parent::toArray($request),
            'images' => FileAttachmentResource::collection($this->images()),
            'image' => $this->image()->get()->first()->url() ?? Helper::$placeholderImageUrl,
            ...($this->showOwner ? ['owner' => $this->user] : []),
            'brand' => $this->brand,
            'orders' => $showOrders == true ?  $this->orders()->count() : null,
            'sales' => $this->showSales == true ?  $this->sales()->count() : null,
        ];
    }
}
