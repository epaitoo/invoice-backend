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
        'reference',
        'terms_and_conditions',
        'discount',
    ];

    protected $guarded = [
        'sub_total', 'grand_total'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    // public function setSubTotalAttribute($value)
    // {
    //     $this->attributes['sub_total'] = $value;
    //     $discount = $this->attributes['discount'];
    //     $this->attributes['grand_total'] = $value - $discount;
    // }


    // Getters mutator for human readable time
    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->diffForHumans();
    }

}
