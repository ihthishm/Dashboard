<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory,SoftDeletes;

    public function item(){
        return $this->hasMany(Item::class);
    }

    // relation with store category
    public function store_category(){
        return $this->belongsTo(StoreCategory::class);

    }

    public function city(){
        return $this->belongsTo(City::class);

    }
}
