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
            'deliberation_id' => [
                'required',
                'exists:deliberations,id',
            ],
            'file' => [
                'required', 
                'file', 
                'mimes:xlsx,xls'
            ],
        ];
    }
}
