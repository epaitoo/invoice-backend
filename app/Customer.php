<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'customer_name', 'customer_email', 'customer_phone_number', 'customer_address'
    ];

    protected $dates = ['deleted_at'];


    public function invoices()
    {
      return $this->hasMany(\App\Invoice::class);
    }

    // Getters mutator for human readable time
    public function getCreatedAtAttribute($value) {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value) {
        return date('d-m-Y H:i:s', strtotime($value));
    }


}
