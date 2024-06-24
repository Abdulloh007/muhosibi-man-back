<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Cashbox extends Model
{
    use HasFactory; 

    protected $fillable = [
        'title',
        'balance',
        'organization_id',
        'status',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    

    private function decryptAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }
    
    public function getTitleAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = Crypt::encryptString($value);
    }
    // public function getBalanceAttribute($value)
    // {
    //     return $this->decryptAttribute($value);
    // }

    // public function setBalanceAttribute($value)
    // {
    //     $this->attributes['balance'] = Crypt::encryptString($value);
    // }

}
