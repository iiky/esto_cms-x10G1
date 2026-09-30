<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'username',
        'name',
        'email',
        'foto',
        'password',
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
    ];

    /**
     * Relationship with Profile model.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get user avatar URL with fallback.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->profile && !empty($this->profile->avatar)) {
            return $this->profile->avatar_url;
        }

        if (!empty($this->foto) && $this->foto !== 'no_image.jpg') {
            if (filter_var($this->foto, FILTER_VALIDATE_URL)) {
                return $this->foto;
            }
            if (file_exists(public_path('assets/images/foto/' . $this->foto))) {
                return asset('/assets/images/foto/' . $this->foto);
            }
            if (file_exists(storage_path('app/public/' . $this->foto))) {
                return asset('storage/' . $this->foto);
            }
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=ffffff&size=128';
    }

    /**
     * Get display role name.
     */
    public function getRoleNameAttribute(): string
    {
        return $this->roles->pluck('name')->first() ?? 'User';
    }
}
