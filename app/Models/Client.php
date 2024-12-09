<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Translatable\HasTranslations;

class Client extends Model implements JWTSubject
{
    use HasFactory,SoftDeletes,HasApiTokens,HasTranslations;
    protected $guarded = [];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [
            'type' => 'client',
        ];
    }


}
