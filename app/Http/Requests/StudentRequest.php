<?php

namespace App\Http\Requests;


class StudentRequest extends BaseFormRequest
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
            'firstname' => [
                'required',
                'between:2,255'
            ],
            'gender' => [
                'required',
            ],
            'phone' => [
                'required',
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
