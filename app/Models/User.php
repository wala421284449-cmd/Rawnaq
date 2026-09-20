<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'gender',
        'status',
        'addresses_id',
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

    public function address()
    {
        return $this->belongsTo(Address::class, 'addresses_id', 'id');
    }


    public function actor()
    {
        return $this->morphTo();
    }
    // داخل كلاس User في app/Models/User.php

    public function isCustomer()
    {
        return $this->role === 'customer'; // أو $this->type === 'customer'
    }

    public function isOwner()
    {
        return $this->role === 'owner'; // أو $this->type === 'owner'
    }

    public function isAdmin()
    {
        return $this->role === 'admin'; // أو $this->type === 'admin'
    }
    public function contactMessages()
    {
        return $this->hasMany(ContactMessage::class, 'user_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }
}
