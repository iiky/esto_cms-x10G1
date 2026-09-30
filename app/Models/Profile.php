<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'phone_number',
        'birth_date',
        'gender',
        'address',
        'bio',
        'avatar',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'social_linkedin',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->avatar)) {
            if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
                return $this->avatar;
            }
            return asset('storage/' . $this->avatar);
        }

        $name = $this->user ? $this->user->name : 'User';
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=6366f1&color=ffffff&size=128';
    }
}
