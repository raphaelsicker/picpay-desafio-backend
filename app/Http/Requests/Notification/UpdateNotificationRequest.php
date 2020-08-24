<?php

namespace App\Http\Requests\Notification;

use App\Rules\UserHasBalance;
use App\Rules\UserIsCommon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNotificationRequest extends FormRequest
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
            'transfer_id' => [
                'bail',
                'required',
                'int',
                'exists:transfers,id',
            ],
            'status' => [
                Rule::in([
                    'canceled',
                    'approved'
                ])
            ],
        ];
    }
}
