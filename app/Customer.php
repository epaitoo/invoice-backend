<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'userId','customer_name', 'customer_email', 'customer_phone_number', 'customer_address'
    ];

    // Getters mutator for human readable time
     public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }


}
