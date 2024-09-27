<?php

namespace App\Http\Resources;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            ...parent::toArray($request),
            // 'state' => State::find($this->state_id)->name,
            // 'country' => Country::find($this->country_id)->name,
            // 'balance' => $this->wallet()->balance()
        ];
    }
}
