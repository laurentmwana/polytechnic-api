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
                'between:2,20'
            ],
            'credits' => [
                'required',
                'number',
                'between:2,20'
            ],
            'teacher_id' => [
                'required',
                'exists:tearchers,id'
            ],
            'level_id' => [
                'required',
                'exists:levels,id'
            ],
        ];
    }
}
