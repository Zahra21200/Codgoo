<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Addon extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public function products()
    {
        return $this->hasMany(ProductAddon::class);
    }
    
    
}
