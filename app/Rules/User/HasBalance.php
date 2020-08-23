<?php

namespace App\Rules\User;

use App\Services\Contracts\UserServiceContract;
use Illuminate\Contracts\Validation\Rule;

class HasBalance implements Rule
{
    /**
     * @var UserServiceContract
     */
    private $userService;

    /**
     * @var int
     */
    private $payerId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $payerId)
    {
        $this->payerId = $payerId;
        $this->userService = app(UserServiceContract::class);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = $this->userService->find($this->payerId);
        return $user['money'] >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You have no balance for this transaction';
    }
}
