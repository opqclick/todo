<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'deadline', 'assigned_to', 'status'];

    protected function deadline(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::create($value)->format('Y-m-d'),
            set: fn (string $value) => Carbon::create($value),
        );
    }
}
