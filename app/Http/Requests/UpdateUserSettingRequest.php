<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserSettingRequest extends FormRequest
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
            'followup_interval_days' => 'required',
            'email_signature' => 'nullable',
            'mail_type' => 'nullable',
            'mail_host' => 'nullable',
            'mail_port' => 'nullable',
            'mail_username' => 'nullable',
            'mail_password' => 'nullable',
            'mail_encryption' => 'nullable',
            'mail_from_address' => 'nullable',
            'mail_from_name' => 'nullable',
            'bcc_name' => 'nullable',
        ];
    }
}
