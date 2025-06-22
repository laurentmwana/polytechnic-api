<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends BaseFormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation appliquées à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'between:2,255',
            ],
            'description' => [
                'required',
                'string',
                'between:100,9000',
            ],
            'content' => [
                'required',
                'string',
                'min:100',
            ],
            'level_id' => [
                'required',
                'integer',
                'exists:levels,id',
            ],
            'year_academic_id' => [
                'nullable',
                'integer',
                'exists:year_academics,id',
            ],
            'url' => [
                'nullable',
                'url',
            ],

            'tags' => [
                'array',
            ]
        ];
    }
}
