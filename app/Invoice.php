<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number',
        'customer_id',
        'date',
        'due_date',
        'invoice_items',
        'reference',
        'terms_and_conditions',
        'grand_total'
    ];

    protected $casts = [
        'invoice_items' => 'array'
    ];

    // Defining Relationship between Customer Table
    public function customer()
    {
    return $this->belongsTo(\App\Customer::class);
    }

   
    // Getters mutator for human readable time
    public function getCreatedAtAttribute($value) {
        return date('d-m-Y H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value) {
        return date('d-m-Y H:i:s', strtotime($value));
    }

}
