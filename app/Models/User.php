<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable, CanResetPasswordTrait;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'password', 
        'birth_date',
        'profile_picture',
        'is_self_pay',
        'address',
        'phone_number'
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'is_self_pay' => 'boolean'
    ];

    // Password Mutator using Laravel 9+ Attribute Casting
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value) // Hashing the password before saving
        );
    }

    // Full Name Accessor
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}"
        );
    }

    // Profile Picture Accessor with Fallback
    protected function profilePicture(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? 'https://via.placeholder.com/150'
        );
    }

    // Utility Methods
    public function hasCompletedProfile(): bool
    {
        return !empty($this->first_name) && 
               !empty($this->last_name) && 
               !empty($this->email) && 
               !empty($this->birth_date);
    }

    public function getAge(): ?int
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    // Static Factory Method
    public static function createWithDefaults(array $attributes)
    {
        // Validate required attributes
        $validatedData = validator($attributes, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'birth_date' => 'required|date',
        ])->validate();

        // Set defaults
        $defaults = [
            'is_self_pay' => false
        ];

        // Create user
        return self::create(array_merge($defaults, $validatedData));
    }
}
