<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;

final class ResponseSuccess implements Responsable
{
    /**
     * @param int $status
     * @param string $message
     * @param array $response
     */
    public function __construct(
        private string $message,
        private int $status_code = Response::HTTP_OK,
        private array $response = []
    ) {}

    public function toResponse($request): JsonResponse
    {
        $payload = [
            'status' => 'success',
            'message' => $this->message,
        ];

        if (!empty($this->response['data'])) {
            $payload['data'] = $this->response['data'];
        }

        if (!empty($this->response['meta'])) {
            $payload['meta'] = $this->response['meta'];
        }

        return response()->json($payload, $this->status_code);
    }
}
