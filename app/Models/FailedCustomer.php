<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailedCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
    ];

    public function images(){
        return $this->hasMany(FailedCustomerImage::class, 'failed_customer_id');
    }
}
