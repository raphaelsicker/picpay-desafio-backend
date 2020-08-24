<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveNotificationRequest extends FormRequest
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
                    'pending',
                    'canceled',
                    'approved'
                ])
            ],
        ];
    }
}
