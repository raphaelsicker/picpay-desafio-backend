<?php

namespace App\Http\Requests\User;

use App\Rules\User\HasBalance as UserHasBalance;
use App\Rules\User\IsCommon as UserIsCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payee_id' => [
                'bail',
                'int',
                'exists:users,id'
            ],
            'payer_id' => [
                'bail',
                'int',
                'exists:users,id',
                new UserIsCommon
            ],
            'value' => [
                'bail',
                'numeric',
                'min:0.01',
                new UserHasBalance($this->input('payer_id'))
            ],
            'status' => [
                Rule::in([
                    'pending',
                    'canceled',
                    'approved'
                ])
            ],
        ];
    }
}
