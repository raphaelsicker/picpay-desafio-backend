<?php

namespace App\Http\Requests\Transfer;


use App\Rules\UserHasBalance;
use App\Rules\UserIsCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveTransferRequest extends FormRequest
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
