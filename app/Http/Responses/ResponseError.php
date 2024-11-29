<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

final class ResponseError implements Responsable
{
    /**
     * @param int $status
     * @param string $message
     */
    public function __construct(
        private string $message,
        private int $status_code = Response::HTTP_INTERNAL_SERVER_ERROR,
        private array $data = []
    ) {}

    public function toResponse($request): JsonResponse
    {
        $payload = [
            'status' => 'error',
            'message' => $this->message,
        ];

        if (!empty($this->data)) {
            $payload['data'] = $this->data;
        }

        return response()->json($payload, $this->status_code);
    }

    public function status() {}
}
