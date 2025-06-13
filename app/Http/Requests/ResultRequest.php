<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules;
use App\Rules\StudentHasAccountRule;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rules\Unique;


class ResultRequest extends BaseFormRequest
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
        $id = $this->input('id');

        return [
            'student_id' => [
                'required',
                'exists:students,id',
                new StudentHasAccountRule($id),
            ],

            'deliberation_id' => [
                'required',
                'exists:deliberation_id,id',
            ],

            'file' => ['required', 'file', 'mimes:pdf'],
            'is_eligible' => ['required', 'boolean']
        ];
    }
}
