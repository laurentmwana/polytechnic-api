<?php

namespace App\Rules;

use Closure;
use App\Models\Student;
use Illuminate\Contracts\Validation\ValidationRule;

class StudentHasAccountRule implements ValidationRule
{
    public function __construct(private ?int $userId) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $query = Student::where('id', $value)
            ->whereNotNull('user_id');

        if ($this->userId !== null) {
            $query->where('user_id', '!=', $this->userId);
        }

        $student = $query->first();

        if ($student) {
            $fail("cet étudiant a déjà un compte");
        }
    }
}
