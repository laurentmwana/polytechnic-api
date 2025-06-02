<?php

namespace App\Http\Requests;


class DeliberationRequest extends BaseFormRequest
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
            'start_at' => [
                'required',
            ],
            'criteria' => [
                'required',
                'between:50,9000'
            ],
            'level_id' => [
                'required',
                'exists:levels,id'
            ],
             'year_academic_id' => [
                'required',
                'exists:year_academics,id'
            ],
        ];
    }
}
