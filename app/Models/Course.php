<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'is_paid',
        'cost',
        'starts_at',
        'ends_at',
    ];

    public function advisor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function attendances()
    {
        return $this->belongsToMany(User::class, 'attendance')->withPivot('date');
    }
}
