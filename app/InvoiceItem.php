<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id' ,'quantiy', 'description', 'unit_price', 'total'
    ];

}
