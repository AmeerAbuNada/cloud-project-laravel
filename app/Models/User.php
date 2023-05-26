<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image == null ? asset('crm-assets/dist/img/blank.png') : Storage::url($this->image)
        );
    }

    //role_name
    public function getRoleNameAttribute()
    {
        return ucfirst($this->role);
    }

    public function getIsRegistrationCompleteAttribute()
    {
        if ($this->role == 'trainee' || $this->role == 'advisor') {
            if (!$this->id_card) return false;
        }
        return true;
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'user_id', 'id');
    }

    public function appliedCourses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function attendances()
    {
        return $this->belongsToMany(Course::class, 'attendance')->withPivot('date');
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class, $this->role . '_id', 'id');
    }

    public function logs() {
        return $this->hasMany(Log::class);
    }
}
