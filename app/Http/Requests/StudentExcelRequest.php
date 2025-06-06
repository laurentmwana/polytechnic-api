<?php

namespace App\Http\Requests;

class StudentExcelRequest extends BaseFormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'excel' => [
                'required',
                'file',
                'mimes:xlsx,xls'
            ],
        ];
    }
}
