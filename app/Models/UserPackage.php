<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'start_date',
        'expiry_date',
        'status',
    ];

    public function customer(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package(){
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function payments(){
        return $this->hasMany(Payment::class, 'user_package_id');
    }
}
