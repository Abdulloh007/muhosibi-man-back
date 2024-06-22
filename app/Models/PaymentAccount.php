<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class PaymentAccount extends Model 
{
    use HasFactory;

    protected $fillable = [
        'number',
        'BIC',
        'сorrespondent_account', 
        'comments',
        'status',
        'owner_id',
        'balance'
    ];

    protected $casts = [
        'number' => 'integer',
    ];

    public function owner()
    {
        return $this->belongsTo(Counterparty::class, 'owner_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'payment');
    }

    public function getNumberAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function getBICAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function getCorrespondentAccountAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function getCommentsAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Encrypting attributes when setting

    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = Crypt::encryptString($value);
    }

    public function setBICAttribute($value)
    {
        $this->attributes['BIC'] = Crypt::encryptString($value);
    }

    public function setCorrespondentAccountAttribute($value)
    {
        $this->attributes['сorrespondent_account'] = Crypt::encryptString($value);
    }

    public function setCommentsAttribute($value)
    {
        $this->attributes['comments'] = Crypt::encryptString($value);
    }
}
