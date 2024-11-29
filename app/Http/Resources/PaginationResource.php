<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $from = ($this->currentPage() * $this->perPage() - $this->perPage()) + 1;
        return [
            'total' => $this->total(),
            'has_pages' => $this->hasPages(),
            'has_more_pages' => $this->hasMorePages(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'from' => $from,
            'to' => ($this->count() + $from) - 1,
        ];
    }
}
