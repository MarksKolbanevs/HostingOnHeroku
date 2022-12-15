<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStorageRequest extends FormRequest
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
                'user_id' => ['required'],
                'capacity(GB)' => ['required'],
                'used(GB)' => ['required'],
                'empty(GB)' => ['required', 'email'],
            ];
        }else if ($method == 'PATCH'){
            return [
                'user_id' => ['sometimes','required'],
                'capacity(GB)' => ['sometimes','required'],
                'used(GB)' => ['sometimes','required'],
                'empty(GB)' => ['sometimes','required'],
            ];
        }
    }
}
