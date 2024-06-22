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

}
