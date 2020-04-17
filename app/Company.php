<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'company_name', 'company_email', 'company_phone_number', 'company_address'
    ];


    // Getters mutator for human readable time
     public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

}
