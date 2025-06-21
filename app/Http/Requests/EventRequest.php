<?php

namespace App\Http\Requests;


class EventRequest extends BaseFormRequest
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
            'title' => [
                'required',
                'between:2,255'
            ],
            'description' => [
                'required',
                'between:100,9000'
            ],
            'level_id' => [
                'required',
                'exists:leves,id'
            ],
        ];
    }
}
