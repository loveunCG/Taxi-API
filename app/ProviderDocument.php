<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderDocument extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'document_id',
        'url',
        'unique_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The services that belong to the user.
     */
    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }
    /**
     * The services that belong to the user.
     */
    public function document()
    {
        return $this->belongsTo('App\Document');
    }
}
