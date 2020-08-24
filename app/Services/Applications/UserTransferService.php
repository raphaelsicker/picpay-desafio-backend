<?php


namespace App\Services\Applications;


use App\Repositories\Contracts\NotificationRepositoryContract;
use App\Repositories\Contracts\TransferRepositoryContract;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Rules\UserHasBalance;
use App\Rules\UserIsCommon;
use App\Services\Contracts\UserTransferServiceContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserTransferService implements UserTransferServiceContract
{
    /**
     * @var UserRepositoryContract
     */
    private $userRepository;

    /**
     * @var TransferRepositoryContract
     */
    private $transferRepository;

    /**
     * @var NotificationRepositoryContract
     */
    private $notificationRepository;

    public function __construct(
        UserRepositoryContract $userRepository,
        TransferRepositoryContract $transferRepository,
        NotificationRepositoryContract $notificationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->transferRepository = $transferRepository;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @var array
     */
    private $transferData;

    public function process(array $transferData): bool
    {
        $this->transferData = $transferData;

        if($this->isValidTransfer()) {
            $this->userRepository->balanceIncrement(
                $transferData['payee_id'],
                $transferData['value']
            );

            $this->transferRepository->finish($this->transferData['id']);

            return true;
        }
        return true;
    }

    public function revert(array $transferData): bool
    {
        $this->transferData = $transferData;

        if($this->isValidTransfer()) {
            $this->userRepository->balanceDecrement(
                $transferData['payer_id'],
                $transferData['value']
            );

            return true;
        }
        return false;
    }

    public function finish(array $transfer): bool
    {
        $notification = $this->notificationRepository->save([
            'transfer_id' => $transfer['id']
        ]);

        return !empty($notification['id'] ?? false);
    }

    private function isValidTransfer(): bool
    {
        return Validator::make(
            $this->transferData,
            $this->getTransferRules()
        )->passes();
    }

    private function getTransferRules(): array
    {
        return [
            'id' => [
                'bail',
                'required',
                'int',
                'exists:transfers,id'
            ],
            'payee_id' => [
                'bail',
                'required',
                'int',
                'exists:users,id'
            ],
            'payer_id' => [
                'bail',
                'required',
                'int',
                'exists:users,id',
                new UserIsCommon
            ],
            'value' => [
                'bail',
                'required',
                'numeric',
                'min:0.01',
                new UserHasBalance($this->transferData['payer_id'] ?? null)
            ],
            'status' => [
                Rule::in([
                    'approved'
                ])
            ],
        ];
    }
}
