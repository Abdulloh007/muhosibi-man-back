<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Activities extends Model
{
    use HasFactory; 

    protected $fillable = [
        'title',
        'description',
    ];

    public function organizations(){
        return $this->belongsToMany(Organization::class);
    }


    
    // private function decryptAttribute($value)
    // {
    //     try {
    //         return Crypt::decryptString($value);
    //     } catch (DecryptException $e) {
    //         return null;
    //     }
    // }
    
    // public function getTitleAttribute($value)
    // {
    //     return $this->decryptAttribute($value);
    // }

    // public function setTitleAttribute($value)
    // {
    //     $this->attributes['title'] = Crypt::encryptString($value);
    // }

    // public function getDescriptionAttribute($value)
    // {
    //     return $this->decryptAttribute($value);
    // }

    // public function setDescriptionAttribute($value)
    // {
    //     $this->attributes['description'] = Crypt::encryptString($value);
    // }


}
