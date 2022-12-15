<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $method = $this->method();

        if ($method == 'PUT'){
            return [
                'subscription_id' => ['required'],
                'name' => ['required'],
                'surname' => ['required'],
                'email' => ['required', 'email'],
                'phone' => ['required']
            ];
        }else if ($method == 'PATCH'){
            return [
                'subscription_id' => ['sometimes','required'],
                'name' => ['sometimes','required'],
                'surname' => ['sometimes','required'],
                'email' => ['sometimes','required', 'email'],
                'phone' => ['sometimes','required']
            ];
        }
    }
}
