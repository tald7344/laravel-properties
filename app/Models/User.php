<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'location',
        'profile_image',
        'profile_documents',
        'role',
        'phone_verified',
        'is_verified_owner',
        'password',
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
            'phone_verified' => 'boolean',
            'is_verified_owner' => 'boolean',
            'profile_documents' => 'array',
        ];
    }

    public function properties() { return $this->hasMany(Property::class); }
    public function favoriteProperties() { return $this->belongsToMany(Property::class, 'favorites')->withTimestamps(); }
    public function roles() { return $this->belongsToMany(Role::class); }
    public function subscriptions() { return $this->hasMany(Subscription::class); }
    public function activeSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'approved')
            ->where(function ($query) {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where('ends_at', '>', now())
            ->latest('ends_at')
            ->first();
    }
    public function hasRole(string $role): bool { return $this->role === $role || $this->roles()->where('name',$role)->exists(); }
}
