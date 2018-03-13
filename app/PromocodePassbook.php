<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromocodePassbook extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status', 'promocode_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at'
    ];


   /**
     * The services that belong to the user.
     */
    public function promocode()
    {
        return $this->belongsTo('App\Promocode')->withTrashed();
    }
}
