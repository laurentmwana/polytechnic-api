<?php

namespace App\Http\Requests;


class LevelRequest extends BaseFormRequest
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
            'name' => [
                'required',
                'between:2,255'
            ],
            'alias' => [
                'required',
                'between:2,255'
            ],
            'programme' => [
                'required',
            ],
            'option_id' => [
                'required',
                'exists:options,id'
            ],
        ];
    }
}
