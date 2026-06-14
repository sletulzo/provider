<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Order;
use App\Models\OrderWaiting;
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
     * Client commandeur créé par un fournisseur (accès limité aux commandes).
     */
    public function managesOwnCart(): bool
    {
        return $this->isCustomer() && $this->is_only_order;
    }

    public function countCartItems(): int
    {
        return (int) OrderWaiting::query()
            ->forUserCart($this)
            ->where('quantity', '>', 0)
            ->sum('quantity');
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
        return $this->getTheme()['primary'];
    }

    /**
     * Theme colors for the current user type
     *
     * @return array{primary: string, primary_dark: string, secondary: string}
     */
    public function getTheme(): array
    {
        if ($this->isProvider()) {
            return [
                'primary' => '#0a9f38',
                'primary_dark' => '#087a2b',
                'secondary' => '#3ecf7a',
            ];
        }

        return [
            'primary' => '#3645b1',
            'primary_dark' => '#2a3690',
            'secondary' => '#44beee',
        ];
    }

    /**
     * Get orders by provider
     *
     * @var object
     */
    public function getOrders()
    {
        $query = Order::orderBy('created_at', 'desc');

        if ($this->isCustomer() && $this->is_only_order)
            $query = $query->where('user_id', $this->id);

        return $query->get();
    }

    public function getOrdersCurrentMonth()
    {
        $query = Order::query();

        if ($this->isCustomer() && $this->is_only_order) {
            $query->where('user_id', $this->id);
        }

        return $query
            ->whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])
            ->count();
    }

    public function getOrdersPreviousMonth()
    {
        $query = Order::query();

        if ($this->isCustomer() && $this->is_only_order) {
            $query->where('user_id', $this->id);
        }

        return $query
            ->whereBetween('created_at', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth()
            ])
            ->count();
    }

    public function getOrdersEvolutionPercentage(): float
    {
        $currentMonth = $this->getOrdersCurrentMonth();
        $previousMonth = $this->getOrdersPreviousMonth();

        if ($previousMonth == 0) {
            return $currentMonth > 0 ? 100 : 0;
        }

        return round(
            (($currentMonth - $previousMonth) / $previousMonth) * 100,
            1
        );
    }
}
