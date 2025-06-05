<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Student;
use App\Models\ActualLevel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $student =  new Student([
            'name' => $row['name'],
            'firstname' => $row['firstname'],
            'gender' => $row['gender'],
            'phone' => $row['phone'],
        ]);

        ActualLevel::create([
            'student_id' => $student->id,
            'level_id' => $row['level'],
            'year_academic_id' => $row['year']
        ]);

        User::create([
            'name' => '',
            'email' => $row['email'],
            'password' => Hash::make('password')
        ]);

        return $student;
    }
}
