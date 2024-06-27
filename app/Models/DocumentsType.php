<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class DocumentsType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'metatag',
        'type',
        'act',
        'hasInvoice'
    ];

    protected $casts = [
        'metatag' => 'json',
        'hasInvoice' => 'boolean'
    ];

    public function documents()
    {
        return $this->hasMany(Documents::class, 'doc_type');
    }

}
