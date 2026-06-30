<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\ExamResult;
use App\Models\FeePayment;
use App\Models\FeeType;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '01700000000',
        ]);

        User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@school.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'phone' => '01700000001',
        ]);

        $classes = [
            ['name' => 'Class 6', 'code' => 'C6', 'sections' => ['A', 'B']],
            ['name' => 'Class 7', 'code' => 'C7', 'sections' => ['A', 'B']],
            ['name' => 'Class 8', 'code' => 'C8', 'sections' => ['A', 'B', 'C']],
            ['name' => 'Class 9', 'code' => 'C9', 'sections' => ['A', 'B']],
            ['name' => 'Class 10', 'code' => 'C10', 'sections' => ['A', 'B', 'C']],
        ];

        $schoolClasses = collect();
        foreach ($classes as $classData) {
            $class = SchoolClass::create([
                'name' => $classData['name'],
                'code' => $classData['code'],
            ]);
            foreach ($classData['sections'] as $sectionName) {
                $class->sections()->create(['name' => $sectionName]);
            }
            $schoolClasses->push($class);
        }

        $teachers = [
            ['employee_id' => 'T001', 'name' => 'Md. Rahman', 'email' => 'rahman@school.com', 'specialization' => 'Mathematics', 'gender' => 'male'],
            ['employee_id' => 'T002', 'name' => 'Fatima Begum', 'email' => 'fatima@school.com', 'specialization' => 'English', 'gender' => 'female'],
            ['employee_id' => 'T003', 'name' => 'Karim Uddin', 'email' => 'karim@school.com', 'specialization' => 'Science', 'gender' => 'male'],
            ['employee_id' => 'T004', 'name' => 'Nasreen Akter', 'email' => 'nasreen@school.com', 'specialization' => 'Bangla', 'gender' => 'female'],
            ['employee_id' => 'T005', 'name' => 'Abdul Jabbar', 'email' => 'jabbar@school.com', 'specialization' => 'ICT', 'gender' => 'male'],
        ];

        $teacherModels = collect();
        foreach ($teachers as $i => $t) {
            $teacherModels->push(Teacher::create([
                ...$t,
                'phone' => '017'.str_pad($i + 1, 8, '0', STR_PAD_LEFT),
                'qualification' => 'Masters',
                'joining_date' => '2020-01-15',
                'salary' => 35000,
                'status' => 'active',
            ]));
        }

        $subjectList = [
            ['name' => 'Bangla', 'code' => 'BAN'],
            ['name' => 'English', 'code' => 'ENG'],
            ['name' => 'Mathematics', 'code' => 'MAT'],
            ['name' => 'Science', 'code' => 'SCI'],
            ['name' => 'ICT', 'code' => 'ICT'],
        ];

        $subjects = collect();
        foreach ($subjectList as $i => $sub) {
            $subjects->push(Subject::create([
                'name' => $sub['name'],
                'code' => $sub['code'],
                'teacher_id' => $teacherModels[$i]->id,
                'full_marks' => 100,
                'pass_marks' => 33,
            ]));
        }

        $studentNames = [
            'Rahim Ahmed', 'Karima Khatun', 'Sakib Hasan', 'Nusrat Jahan', 'Imran Hossain',
            'Tasnim Akter', 'Fahim Islam', 'Sabrina Sultana', 'Arif Khan', 'Mim Akter',
            'Rakib Uddin', 'Puja Rani', 'Tanvir Ahmed', 'Shila Begum', 'Nayeem Hassan',
        ];

        $admissionCounter = 1;
        foreach ($schoolClasses->take(3) as $class) {
            foreach ($class->sections as $section) {
                for ($i = 0; $i < 3; $i++) {
                    $nameIndex = ($admissionCounter - 1) % count($studentNames);
                    Student::create([
                        'admission_no' => 'ADM-2026-'.str_pad($admissionCounter, 4, '0', STR_PAD_LEFT),
                        'roll_no' => (string) ($i + 1),
                        'name' => $studentNames[$nameIndex],
                        'gender' => $nameIndex % 2 === 0 ? 'male' : 'female',
                        'guardian_name' => 'Guardian of '.$studentNames[$nameIndex],
                        'guardian_phone' => '018'.str_pad($admissionCounter, 8, '0', STR_PAD_LEFT),
                        'school_class_id' => $class->id,
                        'section_id' => $section->id,
                        'admission_date' => '2026-01-01',
                        'status' => 'active',
                    ]);
                    $admissionCounter++;
                }
            }
        }

        $feeTypes = [
            ['name' => 'Monthly Tuition', 'amount' => 2000, 'frequency' => 'monthly'],
            ['name' => 'Admission Fee', 'amount' => 5000, 'frequency' => 'one_time'],
            ['name' => 'Exam Fee', 'amount' => 500, 'frequency' => 'quarterly'],
        ];

        foreach ($feeTypes as $fee) {
            FeeType::create([...$fee, 'is_active' => true]);
        }

        $students = Student::all();
        $today = now()->toDateString();

        foreach ($students->take(10) as $student) {
            Attendance::create([
                'student_id' => $student->id,
                'school_class_id' => $student->school_class_id,
                'section_id' => $student->section_id,
                'date' => $today,
                'status' => rand(0, 10) > 2 ? 'present' : 'absent',
                'marked_by' => 1,
            ]);

            FeePayment::create([
                'receipt_no' => 'RCP-2026'.str_pad($student->id, 4, '0', STR_PAD_LEFT),
                'student_id' => $student->id,
                'fee_type_id' => 1,
                'amount_paid' => 2000,
                'payment_date' => $today,
                'payment_method' => 'cash',
                'month' => now()->format('F Y'),
                'collected_by' => 1,
            ]);

            ExamResult::create([
                'student_id' => $student->id,
                'subject_id' => $subjects->random()->id,
                'exam_name' => 'Mid Term 2026',
                'marks_obtained' => rand(40, 95),
                'total_marks' => 100,
                'grade' => 'A',
                'exam_date' => '2026-03-15',
            ]);
        }
    }
}
