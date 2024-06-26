<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use League\CommonMark\Node\Block\Document;

class Documents extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'template',
        'doc_type',
        'with_sign_seal',
        'doc_group_id',
        'public',
        'sum',
        'status',
        'organization_id'
    ];

    protected $casts = [];

    public function documentType()
    {
        return $this->belongsTo(DocumentsType::class, 'doc_type');
    }
    
    public function docGroup()
    {
        return $this->belongsTo(DocGroup::class, 'doc_group_id');
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
        return $this->hasMany(Invoices::class, 'document_id');
    }
}
