<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'student_number' => '2024-0001',
                'first_name'     => 'John',
                'last_name'      => 'Doe',
                'course'         => 'BS Computer Science',
                'year_level'     => 1,
                'email'          => 'john.doe@example.com',
                'phone'          => '09123456789',
            ],
            [
                'student_number' => '2024-0002',
                'first_name'     => 'Jane',
                'last_name'      => 'Smith',
                'course'         => 'BS Information Technology',
                'year_level'     => 2,
                'email'          => 'jane.smith@example.com',
                'phone'          => '09987654321',
            ],
            [
                'student_number' => '2024-0003',
                'first_name'     => 'Robert',
                'last_name'      => 'Johnson',
                'course'         => 'BS Information Systems',
                'year_level'     => 3,
                'email'          => 'robert.j@example.com',
                'phone'          => '09223334444',
            ],
            [
                'student_number' => '2024-0004',
                'first_name'     => 'Emily',
                'last_name'      => 'Davis',
                'course'         => 'BS Computer Engineering',
                'year_level'     => 4,
                'email'          => 'emily.d@example.com',
                'phone'          => '09556667777',
            ],
        ];

        foreach ($students as $student) {
            Student::updateOrCreate(
                ['student_number' => $student['student_number']],
                $student
            );
        }
    }
}
