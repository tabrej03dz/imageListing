<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function parent(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function childrens(){
        return $this->hasMany(Category::class, 'category_id');
    }
}
