<?php

namespace App\Http\Requests;


class CourseRequest extends BaseFormRequest
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
            'code' => [
                'required',
                'alpha_num',
                'between:2,20'
            ],
            'credits' => [
                'required',
                'numeric',
                'between:1,60'
            ],
            'teacher_id' => [
                'required',
                'exists:teachers,id'
            ],
            'level_id' => [
                'required',
                'exists:levels,id'
            ],
        ];
    }
}
