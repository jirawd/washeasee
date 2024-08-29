<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use LucasDotVin\Soulbscription\Models\Concerns\HasSubscriptions;
use Outerweb\Settings\Models\Setting;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, HasApiTokens, HasSubscriptions;

    public function canAccessPanel(Panel $panel): bool
    {
        if($panel->getId() === 'admin') {
            if(str_ends_with($this->email, '@washease.com')) {
                return true;
            }
        }

        if($panel->getId() === 'customer') {
            if($this->role === 'Customer') {
                return true;
            }
        }

        if($panel->getId() === 'laundry-shop') {
            if($this->role === 'LaundryShop' && $this->status === 'APPROVE') {
                return true;
            }
        }

        return false;

    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'laundry_shop_name',
        'laundry_shop_address',
        'laundry_shop_permit',
        'laundry_shop_open_hours',
        'address',
        'avatar',
        'role',
        'is_shop_closed',
        'user_lat',
        'user_long',
        'status',
        'phone_number',
        'avatar_url'
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
        ];
    }
    public function laundry_shop_locations() {
        return $this->belongsTo(LaundryShopLocations::class, 'laundry_shop_id');
    }

    public function shops_rating() {
        return $this->hasMany(LaundryShopRatings::class, 'laundry_shop_id', 'id');
    }

    public function settings() {
        return $this->belongsTo(Setting::class, 'laundry_shop_id', 'id');
    }

    public function shop_services() {
        return $this->hasMany(Services::class, 'laundry_shop_id', 'id');
    }

    public function laundry_shop_rider() {
        return $this->belongsTo(User::class, 'laundry_shop_rider_id', 'id');
    }

    public function laundry_shop_transaction() {
        return $this->hasMany(Transactions::class, 'laundry_shop_id', 'id');
    }

}
