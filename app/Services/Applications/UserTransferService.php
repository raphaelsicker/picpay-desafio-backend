<?php


namespace App\Services\Applications;


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

    public function __construct(
        UserRepositoryContract $userRepository,
        TransferRepositoryContract $transferRepository
    ) {
        $this->userRepository = $userRepository;
        $this->transferRepository = $transferRepository;
    }

    /**
     * @var array
     */
    private $transferData;

    public function process(array $transferData): bool
    {
        $this->transferData = $transferData;

        if($this->isValidTransfer()) {
            $this->balanceIncrement($this->transferData['payee_id']);
            $this->balanceDecrement($this->transferData['payer_id']);
            $this->transferRepository->finish($this->transferData['id']);

            return true;
        }
        return true;
    }

    public function revert(array $transferData): bool
    {
        $this->transferData = $transferData;

        if($this->isValidTransfer()) {
            $this->balanceIncrement($this->transferData['payer_id']);
            $this->balanceDecrement($this->transferData['payee_id']);

            return true;
        }
        return false;
    }

    public function finish(array $transfer): bool
    {
        echo 'finalizou';
    }

    private function balanceIncrement(int $userId)
    {
        $user = $this->userRepository->find($userId);

        $this->userRepository->update(
            ['money' => $user['money'] + $this->transferData['value']],
            $this->transferData['id']
        );
    }

    private function balanceDecrement(int $userId)
    {
        $user = $this->userRepository->find($userId);

        $this->userRepository->update(
            ['money' => $user['money'] - $this->transferData['value']],
            $this->transferData['id']
        );
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
                'required',
                Rule::in([
                    'approved'
                ])
            ],
        ];
    }
}
