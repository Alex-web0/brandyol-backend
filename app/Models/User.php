<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'phone_number',
        'gender',
        'role',
        'password',
        'android_token',
        'ios_token',
        'web_token',

        /// Bans
        'banned',
        'reason',
        'shadow_banned',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'banned' => 'boolean',
        ];
    }

    public function is_customer_account(): bool
    {

        return $this->role == 'customer';
    }

    public function is_admin_account(): bool
    {

        return $this->role == 'admin';
    }

    public function is_manager_account(): bool
    {

        return $this->role == 'manager';
    }

    public function is_staff(): bool
    {

        return $this->is_manager_account() || $this->is_admin_account();
    }

    public function is_staff_account(): bool
    {

        return $this->is_staff();
    }


    public function is_banned(): bool
    {

        return $this->banned == true;
    }


    public function userNotifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
