<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'inn',
        'kpp',
        'tax_system',
        'legal_address',
        'physic_address',
        'owner_id',
        'type',
        'contacts',
        'status',
    ];

    protected $casts = [
        'contacts' => 'json',
    ];

    public function activities()
    {
        return $this->belongsToMany(Activities::class, 'organization_activity', 'organization', 'activity');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function cashboxes()
    {
        return $this->hasMany(Cashbox::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function fiscalConfigs()
    {
        return $this->hasMany(FiscalConfig::class);
    }

    public function stuff()
    {
        return $this->hasMany(Stuff::class);
    }

    public function counterparties()
    {
        return $this->hasMany(Counterparty::class);
    }

    public function documents()
    {
        return $this->hasMany(Documents::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }



    // Mutator for 'title'
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = Crypt::encryptString($value);
    }

    // Accessor for 'title'
    public function getTitleAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'inn'
    public function setInnAttribute($value)
    {
        $this->attributes['inn'] = Crypt::encryptString($value);
    }

    // Accessor for 'inn'
    public function getInnAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'kpp'
    public function setKppAttribute($value)
    {
        $this->attributes['kpp'] = Crypt::encryptString($value);
    }

    // Accessor for 'kpp'
    public function getKppAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'legal_address'
    public function setLegalAddressAttribute($value)
    {
        $this->attributes['legal_address'] = Crypt::encryptString($value);
    }

    // Accessor for 'legal_address'
    public function getLegalAddressAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'physic_address'
    public function setPhysicAddressAttribute($value)
    {
        $this->attributes['physic_address'] = Crypt::encryptString($value);
    }

    // Accessor for 'physic_address'
    public function getPhysicAddressAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'type'
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = Crypt::encryptString($value);
    }

    // Accessor for 'type'
    public function getTypeAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'contacts'
    public function setContactsAttribute($value)
    {
        $this->attributes['contacts'] = Crypt::encryptString($value);
    }

    // Accessor for 'contacts'
    public function getContactsAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }
}
