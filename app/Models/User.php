<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'password' => 'hashed',
    ];

    /**
     * Tenant relation
     *
     * @var object
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    /**
     * User Type relation
     *
     * @var object
     */
    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_type_id');
    }

    /**
     * Return true if user is customer
     *
     * @var boolean
     */
    public function isCustomer()
    {
        return $this->userType?->slug == 'customer' ? true : false;
    }

    /**
     * Return true if user is provider
     *
     * @var boolean
     */
    public function isProvider()
    {
        return $this->userType?->slug == 'provider' ? true : false;
    }

    /**
     * Get navigation slug
     *
     * @var object
     */
    public function getNavigationSlug()
    {
        if ($this->userType)
            return $this->userType->slug;

        return 'customer';
    }

    /**
     * Return color of user
     *
     * @var string
     */
    public function getColor()
    {
        if ($this->isProvider())
            return '#3645b1';

        return '#0a9f38';
    }

    /**
     * Get orders by provider
     *
     * @var object
     */
    public function getOrders()
    {
        $query = Order::orderBy('created_at', 'desc');

        if ($this->isCustomer())
            $query = $query->where('user_id', $this->id);

        return $query->get();
    }
}
