<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'name',
        'phone',
        'line1',
        'line2',
        'city',
        'postcode',
        'state_id',
        'country_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $appends = [
        'full_address'
    ];


    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }


    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }


    public function fullAddress(): Attribute
    {
        $address = $this->line1;

        if ($this->line2 != null) {
            $address .= ', ' . $this->line2;
        }

        if ($this->city != null) {
            $address .= ', ' . $this->city;
        }

        if ($this->postcode != null) {
            $address .= ', ' . $this->postcode;
        }

        if ($this->state != null) {
            $address .= ', ' . $this->state->name;
        }

        if ($this->country != null) {
            $address .= ', ' . (
                ($this->country->name === 'East Malaysia' || $this->country->name === 'West Malaysia') 
                    ? 'Malaysia' 
                    : $this->country->name
            );
        }

        return Attribute::make(
            get: fn() => $address
        );
    }
}
