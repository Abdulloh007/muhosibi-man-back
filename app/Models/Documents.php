<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class Documents extends Model
{
    use HasFactory; 

    protected $fillable = [
        'title',
        'template',
        'metatag',
        'doc_type',
        'with_sign_seal',
        'public',
        'sum',
    ];

    protected $casts = [
        'metatag' => 'json',
    ];

    public function documentType()
    {
        return $this->belongsTo(DocumentsType::class, 'doc_type');
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

    // Mutator for 'template'
    public function setTemplateAttribute($value)
    {
        $this->attributes['template'] = Crypt::encryptString($value);
    }

    // Accessor for 'template'
    public function getTemplateAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'metatag'
    public function setMetatagAttribute($value)
    {
        $this->attributes['metatag'] = Crypt::encryptString($value);
    }

    // Accessor for 'metatag'
    public function getMetatagAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'with_sign_seal'
    public function setWithSignSealAttribute($value)
    {
        $this->attributes['with_sign_seal'] = Crypt::encryptString($value);
    }

    // Accessor for 'with_sign_seal'
    public function getWithSignSealAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'public'
    public function setPublicAttribute($value)
    {
        $this->attributes['public'] = Crypt::encryptString($value);
    }

    // Accessor for 'public'
    public function getPublicAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    // Mutator for 'sum'
    public function setSumAttribute($value)
    {
        $this->attributes['sum'] = Crypt::encryptString($value);
    }

    // Accessor for 'sum'
    public function getSumAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'document_id');
    }
}
