<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'userId',
        'invoice_number',
        'customer_id',
        'customer_name',
        'customer_phone_number',
        'customer_address',
        'date',
        'due_date',
        'invoice_items',
        'reference',
        'terms_and_conditions',
        'discount',
        'sub_total',
        'grand_total'
    ];

    protected $casts = [
        'invoice_items' => 'array'
    ];

   
    // Getters mutator for human readable time
    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

}
