<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $casts = [
        'time' => 'datetime',
    ];

    protected $fillable = [
        'subject',
        'time',
        'trainee_id',
        'advisor_id',
    ];

    public function trainee()
    {
        return $this->belongsTo(User::class, 'trainee_id', 'id');
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id', 'id');
    }
}
