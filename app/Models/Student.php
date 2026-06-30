<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'admission_no', 'roll_no', 'name', 'email', 'phone',
        'date_of_birth', 'gender', 'blood_group', 'address',
        'guardian_name', 'guardian_phone', 'guardian_relation',
        'school_class_id', 'section_id', 'admission_date', 'status',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'admission_date' => 'date',
        ];
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function feePayments(): HasMany
    {
        return $this->hasMany(FeePayment::class);
    }

    public function examResults(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }

    public static function generateAdmissionNo(): string
    {
        $prefix = 'ADM-'.now()->format('Y').'-';
        $lastNumber = static::where('admission_no', 'like', $prefix.'%')
            ->get()
            ->map(fn (Student $s) => (int) substr($s->admission_no, strlen($prefix)))
            ->max() ?? 0;

        return $prefix.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    protected static function booted(): void
    {
        static::creating(function (Student $student) {
            if (empty($student->admission_no)) {
                $student->admission_no = static::generateAdmissionNo();
            }
        });
    }
}
