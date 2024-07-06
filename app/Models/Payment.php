<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_id',
        'date',
        'number',
        'payer_account',
        'payment_sum',
        'payment_purpose',
        'comment',
        'status',
        'owner_id',
        'organization_id',
    ];

    public function owner()
    {
        return $this->belongsTo(Counterparty::class, 'owner_id');
    }

    // Mutator for 'date'
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Crypt::encryptString($value);
    }

    // Mutator for 'number'
    public function setNumberAttribute($value)
    {
        $this->attributes['number'] = Crypt::encryptString($value);
    }

    // Mutator for 'payer_account'
    public function setPayerAccountAttribute($value)
    {
        $this->attributes['payer_account'] = Crypt::encryptString($value);
    }

    // Mutator for 'payment_sum'
    public function setPaymentSumAttribute($value)
    {
        $this->attributes['payment_sum'] = Crypt::encryptString($value);
    }

    // Mutator for 'payment_purpose'
    public function setPaymentPurposeAttribute($value)
    {
        $this->attributes['payment_purpose'] = Crypt::encryptString($value);
    }

    // Mutator for 'currency_agreement'
    public function setCurrencyAgreementAttribute($value)
    {
        $this->attributes['currency_agreement'] = Crypt::encryptString($value);
    }

    // Mutator for 'comment'
    public function setCommentAttribute($value)
    {
        $this->attributes['comment'] = Crypt::encryptString($value);
    }

    // Accessor for 'date'
    public function getDateAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Accessor for 'number'
    public function getNumberAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Accessor for 'payer_account'
    public function getPayerAccountAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Accessor for 'payment_sum'
    public function getPaymentSumAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Accessor for 'payment_purpose'
    public function getPaymentPurposeAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Accessor for 'currency_agreement'
    public function getCurrencyAgreementAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Accessor for 'comment'
    public function getCommentAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }


}