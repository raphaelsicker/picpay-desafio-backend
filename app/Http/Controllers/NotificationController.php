<?php

namespace App\Http\Controllers;

use App\Http\Requests\Notification\SaveNotificationRequest;
use App\Http\Requests\Notification\UpdateNotificationRequest;
use App\Services\Contracts\NotificationServiceContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class NotificationController extends Controller
{
    private $notificationService;

    public function __construct(NotificationServiceContract $notificationServiceContract)
    {
        $this->notificationService = $notificationServiceContract;
    }

    public function index(): JsonResponse
    {
        try{
            return response()->json($this->notificationService->all());
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function store(SaveNotificationRequest $request): JsonResponse
    {
        try {
            if($saved = $this->notificationService->save($request->all())) {
                return response()->json(
                    $saved,
                    JsonResponse::HTTP_CREATED
                );
            }

            return response()->json(
                [
                    'error' => 'Error on save',
                    'mensage' => $this->notificationService->errors
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }

    }

    public function show(int $id): JsonResponse
    {
        try{
            return response()->json($this->notificationService->find($id));
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function update(
        UpdateNotificationRequest $request,
        int $id
    ): JsonResponse {
        try {
            $updated = $this->notificationService->update(
                $request->all(),
                $id
            );

            if($updated) {
                return response()->json(
                    $updated,
                    JsonResponse::HTTP_CREATED
                );
            }

            return response()->json(
                [
                    'error' => 'Error on update',
                    'mensage' => $this->notificationService->errors
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try{
            return response()->json($this->notificationService->delete($id));
        } catch (Exception | Throwable $e) {
            return response()->json(
                ['error' => $e->getMessage()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
