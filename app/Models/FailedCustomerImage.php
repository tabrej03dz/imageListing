<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedCustomerImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'media',
        'failed_customer_id',
    ];

    public function failedCustomer(){
        return $this->belongsTo(FailedCustomer::class, 'failed_customer_id');
    }
}
