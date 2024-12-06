<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avatar',
        'address',
        'hire_date',
        'skills'
    ];

    protected function casts(): array
    {
        return [
            'skills' => 'array',
        ];
    }
    public function setHireDateAttribute($value)
    {
        $this->attributes['hire_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
}
