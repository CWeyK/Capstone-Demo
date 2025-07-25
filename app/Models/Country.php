<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'name', 'currency', 'currency_label',
        'dial_code', 'code', 'conversion_rate', 'gst_rate'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function states(): HasMany
    {
        return $this->hasMany(State::class, 'country_id');
    }

    public function banks(): HasMany
    {
        return $this->hasMany(Bank::class, 'country_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'country_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(CountryProduct::class);
    }

    public function shippingProviders(): HasMany
    {
        return $this->hasMany(ShippingProvider::class, 'country_id');
    }

    
}
