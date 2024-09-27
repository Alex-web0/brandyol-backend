<?php

namespace App\Http\Resources;

use App\Models\FileAttachment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{


    private bool $showOwner;


    public function __construct($resource, $showOwner = false)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->showOwner = $showOwner;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            'images' => FileAttachmentResource::collection($this->images()),
            ...($this->showOwner ? ['owner' => $this->user] : []),
            'category' => $this->category,
            'orders' => !empty($request->most_sales) ?  $this->orders()->count() : null,
        ];
    }
}
