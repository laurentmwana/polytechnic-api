<?php

namespace App\Http\Requests;

use App\Models\Department;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rules\Unique;


class ActualityCommentRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message' => [
                'required',
                'string',
                'between:5,9000',
            ],

            'username' => [
                'required',
                'string',
                'between:3,13',
            ],

        ];
    }
}
