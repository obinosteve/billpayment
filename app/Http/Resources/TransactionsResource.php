<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'requestType' => strtoupper($this->request_type),
            'transactionType' => strtoupper($this->transaction_type),
            'status' => strtoupper($this->status),
            'transactionDate' => $this->transaction_date,
            'currency' => $this->currency,
            'networkProvider' => $this->loadProvider(),
            'recipient' => $this->recipient,
            'remarks' => $this->notes,
        ];
    }

    private function loadProvider(): ?string
    {
        return $this->provider ? $this->provider->name : null;
    }
}
