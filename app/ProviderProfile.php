<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'language',
        'address',
        'address_secondary',
        'city',
        'country',
        'postal_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
