<?php

namespace App\Rules;

use App\Services\Contracts\UserServiceContract;
use Illuminate\Contracts\Validation\Rule;

class UserIsCommon implements Rule
{
    /**
     * @var UserServiceContract
     */
    private $userService;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
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
        return !$this->userService->isShopkeeper($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Only common users can make transfers';
    }
}
