<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicReviewResource extends JsonResource
{
    private function redactUserName(string $name): string
    {
        $arr  = explode(" ", $name);

        return (($arr[0] ?? (empty($arr[1]) ? "****"  : str_repeat("*", strlen($arr[1])))) . " " . "*****");
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
            'user' => null,

            // full_name is to be loaded eagerly
            'redacted_user_name' => $this->redactUserName($this->user->full_name),

        ];
    }
}
