<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use League\CommonMark\Node\Block\Document;

class Counterparty extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'short_name',
        'legal_address',
        'physic_address',
        'site',
        'category_id',
        'inn',
        'kpp',
        'contacts',
        'for_sign_docs',
        'by_person',
        'passport_details',
        'comment',
        'payment_method',
        'organization_id'
    ];

    protected $casts = [
        'inn' => 'integer',
        'kpp' => 'integer',
        'contacts' => 'json',
        'for_sign_docs' => 'json',
        'by_person' => 'json',
        'passport_details' => 'json',
        'comment' => 'json',
    ];

    public function category()
    {
        return $this->hasOne(CountrpartyCategory::class, 'category_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function payment_accounts()
    {
        return $this->hasMany(PaymentAccount::class, 'owner_id');
    }
    
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // Decrypt attribute with try-catch block
    private function decryptAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function getFullNameAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setFullNameAttribute($value)
    {
        $this->attributes['full_name'] = Crypt::encryptString($value);
    }

    public function getShortNameAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setShortNameAttribute($value)
    {
        $this->attributes['short_name'] = Crypt::encryptString($value);
    }

    public function getLegalAddressAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setLegalAddressAttribute($value)
    {
        $this->attributes['legal_address'] = Crypt::encryptString($value);
    }

    public function getPhysicAddressAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setPhysicAddressAttribute($value)
    {
        $this->attributes['physic_address'] = Crypt::encryptString($value);
    }

    public function getSiteAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setSiteAttribute($value)
    {
        $this->attributes['site'] = Crypt::encryptString($value);
    }

    public function getInnAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setInnAttribute($value)
    {
        $this->attributes['inn'] = Crypt::encryptString($value);
    }

    public function getKppAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setKppAttribute($value)
    {
        $this->attributes['kpp'] = Crypt::encryptString($value);
    }

    public function getContactsAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setContactsAttribute($value)
    {
        $this->attributes['contacts'] = Crypt::encryptString($value);
    }

    public function getForSignDocsAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setForSignDocsAttribute($value)
    {
        $this->attributes['for_sign_docs'] = Crypt::encryptString($value);
    }

    public function getByPersonAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setByPersonAttribute($value)
    {
        $this->attributes['by_person'] = Crypt::encryptString($value);
    }

    public function getPassportDetailsAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setPassportDetailsAttribute($value)
    {
        $this->attributes['passport_details'] = Crypt::encryptString($value);
    }

    public function getCommentAttribute($value)
    {
        return $this->decryptAttribute($value);
    }

    public function setCommentAttribute($value)
    {
        $this->attributes['comment'] = Crypt::encryptString($value);
    }
}
