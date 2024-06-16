<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ApiBaseController extends Controller
{
    public function success(array $data): JsonResponse
    {
        return response()->json(array_merge(['success' => true], $data), Response::HTTP_OK);
    }

    public function error(string $message, array $errors = [], int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(['success' => false, 'message' => $message, 'errors' => $errors], $code);
    }
}
