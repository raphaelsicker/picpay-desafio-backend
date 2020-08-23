<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transfer\SaveTransferRequest;
use App\Http\Requests\Transfer\UpdateTransferRequest;
use App\Services\Contracts\TransferServiceContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class TransferController extends Controller
{
    private $transferService;

    public function __construct(TransferServiceContract $transferServiceContract)
    {
        $this->transferService = $transferServiceContract;
    }

    public function index(): JsonResponse
    {
        try{
            return response()->json($this->transferService->all());
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(SaveTransferRequest $request): JsonResponse
    {
        try {
            if($saved = $this->transferService->save($request->all())) {
                return response()->json(
                    $saved,
                    JsonResponse::HTTP_CREATED
                );
            }

            return response()->json(
                [
                    'error' => 'Error on save',
                    'mensage' => $this->transferService->errors
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['erro' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    public function show(int $id): JsonResponse
    {
        try{
            return response()->json($this->transferService->find($id));
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(
        UpdateTransferRequest $request,
        int $id
    ): JsonResponse {
        try {
            $saved = $this->transferService->update(
                $request->all(),
                $id
            );

            if($saved) {
                return response()->json(
                    $saved,
                    JsonResponse::HTTP_CREATED
                );
            }

            return response()->json(
                [
                    'error' => 'Error on update',
                    'mensage' => $this->transferService->errors
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['erro' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try{
            return response()->json($this->transferService->delete($id));
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
