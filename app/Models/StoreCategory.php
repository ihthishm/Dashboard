<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StoreCategory extends Model
{
    use HasFactory,SoftDeletes;

    public function store(){
        return $this->hasMany(Store::class);

    }
}
