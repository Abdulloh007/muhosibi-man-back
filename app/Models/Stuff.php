<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Stuff extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'birthday',
        'gender',
        'citizenship',
        'contract_type',
        'position',
        'begin_date',
        'experience_days',
        'unique_number',
        'passport_details',
        'legal_address',
        'physic_address',
        'inn',
        'payment_method',
        'organization_id',
        'status'
    ];

    protected $casts = [
        'birthday' => 'date',
        'begin_date' => 'date',
        'passport_details' => 'json',
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = Crypt::encryptString($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = Crypt::encryptString($value);
    }

    public function setFatherNameAttribute($value)
    {
        $this->attributes['father_name'] = Crypt::encryptString($value);
    }

    public function setCitizenshipAttribute($value)
    {
        $this->attributes['citizenship'] = Crypt::encryptString($value);
    }

    public function setPositionAttribute($value)
    {
        $this->attributes['position'] = Crypt::encryptString($value);
    }

    public function setExperienceDaysAttribute($value)
    {
        $this->attributes['experience_days'] = Crypt::encryptString($value);
    }

    public function setUniqueNumberAttribute($value)
    {
        $this->attributes['unique_number'] = Crypt::encryptString($value);
    }

    public function setPassportDetailsAttribute($value)
    {
        $this->attributes['passport_details'] = Crypt::encryptString($value);
    }

    public function setLegalAddressAttribute($value)
    {
        $this->attributes['legal_address'] = Crypt::encryptString($value);
    }
    public function setPhysicAddressAttribute($value)
    {
        $this->attributes['physic_address'] = Crypt::encryptString($value);
    }

    public function setInnAttribute($value)
    {
        $this->attributes['inn'] = Crypt::encryptString($value);
    }


    // Mutator for 'first_name'
    public function getFirstNameAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'last_name'
    public function getLastNameAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'father_name'
    public function getFatherNameAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'citizenship'
    public function getCitizenshipAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'position'
    public function getPositionAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'experience_days'
    public function getExperienceDaysAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'unique_number'
    public function getUniqueNumberAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'passport_details'
    public function getPassportDetailsAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'legal_address'
    public function getLegalAddressAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'physic_address'
    public function getPhysicAddressAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'inn'
    public function getInnAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }


}
