<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'school_name',
        'district_id',
        'province_id',
        'phone',
        // 'is_subscribed',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        ];
    }

    /** Get the authenticated URL for the user's private profile picture. */
    public function getProfilePictureUrlAttribute(): ?string
    {
        if (empty($this->profile_picture)) {
            return null;
        }

        return route('avatars.show', [
            'user' => $this->id,
            'v' => substr(sha1((string) $this->profile_picture), 0, 10),
        ], false);
    }
    
    
    /**
     * Get the subscription record for this user.
     */
    // public function subscription(): HasOne
    // {
    //     return $this->hasOne(Subscription::class);
    // }

    /**
     * Check if this user has active subscription.
     */
    // public function hasActiveSubscription(): bool
    // {
    //     $sub = $this->subscription;

    //     if (!$sub) {
    //         return false;
    //     }

    //     return $sub->isActive();
    // }

    /**
     * Get active subscription or null.
     */
    // public function activeSubscription(): ?Subscription
    // {
    //     $sub = $this->subscription;
    //     return ($sub && $sub->isActive()) ? $sub : null;
    // }

    /**
     * Whether a school admin may access this report.
     * Compares school names case-insensitively and ignores surrounding whitespace,
     * matching MySQL's typical collation behaviour used in list queries.
     */
    public function canAccessSchoolReport(Report $report): bool
    {
        if ($this->role !== 'school') {
            return true;
        }

        return filled($this->school_id)
            && filled($report->school_id)
            && (int) $this->school_id === (int) $report->school_id;
    }
}
