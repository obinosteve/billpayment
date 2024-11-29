<?php

namespace App\Http\Resources;

use App\Enums\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseAirtimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'amount' => (float) $request->amount,
            'providerId' => $request->providerId,
            'phoneNumber' => $request->phoneNumber,
            'status' => Status::SUCCESSFUL,
            'walletBalance' => (float) $request->user()->wallet->balance,

        ];
    }
}
