<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rules;
use App\Rules\StudentHasAccountRule;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rules\Unique;


class UserRequest extends BaseFormRequest
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
            'name' => [
                'required',
                'between:2,10'
            ],
            'email' => [
                'required',
                'lowercase',
                'email',
                'max:255',
                (new Unique(User::class))->ignore($id)
            ],
            'student_id' => [
                'required',
                'exists:students,id',
                new StudentHasAccountRule($id),
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ];
    }
}
