<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_package_id',
        'amount',
        'payment_method',
    ];

    public function userPackage(){
        return $this->belongsTo(UserPackage::class, 'user_package_id');
    }
}
