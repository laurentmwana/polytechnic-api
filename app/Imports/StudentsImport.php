<?php

namespace App\Imports;

use App\Enums\GenderEnum;
use App\Enums\RoleUserEnum;
use App\Models\User;
use App\Models\Student;
use App\Models\Level;
use App\Models\YearAcademic;
use App\Notifications\NewStudent;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $levelExists = Level::where('id', $row['level'])->exists();
        $yearExists = YearAcademic::where('id', $row['year'])->exists();

        if (!$levelExists || !$yearExists) {
            return null;
        }

        $user = User::create([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make('12345678'),
            'roles' => [RoleUserEnum::STUDENT->value]
        ]);

        $student = Student::create([
            'name' => $row['name'],
            'firstname' => $row['firstname'],
            'gender' => $row['gender'],
            'phone' => $row['phone'],
            'registration_token' => Str::random(10),
            'user_id' => $user->id,
        ]);

        if (!($student instanceof Student)) {
            throw new \Exception("Nous n'avons pas pu effectuer cette action");
        }

        $student->actualLevel()->create([
            'level_id' => $row['level'],
            'year_academic_id' => $row['year']
        ]);

        $user->notify(new NewStudent());

        return $student;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'gender' => ['required', Rule::enum(GenderEnum::class)], // Exemple : M ou F
            'phone' => 'required|max:20',
            'email' => 'required|email|unique:users,email',
            'level' => 'required|integer|exists:levels,id',
            'year' => 'required|integer|exists:year_academics,id',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'gender.required' => 'Le genre est obligatoire.',
            'gender.in' => 'Le genre doit être M ou F.',
            'phone.required' => 'Le téléphone est obligatoire.',
            'email.required' => "L'email est obligatoire.",
            'email.email' => "L'email doit être une adresse valide.",
            'email.unique' => "Cet email est déjà utilisé.",
            'level.required' => 'Le niveau est obligatoire.',
            'level.exists' => 'Le niveau sélectionné est invalide.',
            'year.required' => "L'année académique est obligatoire.",
            'year.exists' => "L'année académique sélectionnée est invalide.",
        ];
    }
}
