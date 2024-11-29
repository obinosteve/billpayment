<?php

namespace App\Http\Resources;

use App\Enums\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'firstName' => ucwords($this->first_name),
            'lastName' => ucwords($this->last_name),
            'email' => strtolower($this->email),
            'phoneNumber' => strtolower($this->phone),
            'lastLogin' => $this->last_login_at,
            'status' => Status::getLabel($this->status),
        ];
    }
}
