<?php

namespace App\Http\Requests;


class JuryRequest extends BaseFormRequest
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
            'deliberation_id' => [
                'required',
                'exists:deliberations,id'
            ],

            'teacher_id' => [
                'required',
                'exists:teachers,id'
            ],
        ];
    }
}
