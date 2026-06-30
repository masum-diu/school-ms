<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'employee_id', 'name', 'email', 'phone', 'gender',
        'qualification', 'specialization', 'joining_date', 'salary', 'address', 'status',
    ];

    protected function casts(): array
    {
        return [
            'joining_date' => 'date',
            'salary' => 'decimal:2',
        ];
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public static function generateEmployeeId(): string
    {
        $prefix = 'EMP-'.now()->format('Y').'-';
        $lastNumber = static::where('employee_id', 'like', $prefix.'%')
            ->get()
            ->map(fn (Teacher $t) => (int) substr($t->employee_id, strlen($prefix)))
            ->max() ?? 0;

        return $prefix.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    protected static function booted(): void
    {
        static::creating(function (Teacher $teacher) {
            if (empty($teacher->employee_id)) {
                $teacher->employee_id = static::generateEmployeeId();
            }
        });
    }
}
