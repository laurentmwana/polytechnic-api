<?php

namespace App\Http\Requests;


class TeacherRequest extends BaseFormRequest
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
            'department_id' => [
                'required',
                'exists:departments,id'
            ],
        ];
    }
}
