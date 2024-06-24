<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use League\CommonMark\Node\Block\Document;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'operation',
        'type_id',
        'doctype_id',
        'document_id',
        'resource',
        'title',
        'details',
        'date',
        'total',
        'total_tax',
        'counterparty_id',
        'organization_id',
        'payment_account',
    ];

    protected $casts = [];

    public function type()
    {
        return $this->belongsTo(TransactionType::class, 'type_id');
    }

    public function paymentAccount()
    {
        return $this->belongsTo(PaymentAccount::class, 'payment_account');
    }

    public function counterparty()
    {
        return $this->belongsTo(Counterparty::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function getDetailsAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (DecryptException $e) {
            return null;
        }
    }

    public function setDetailsAttribute($value)
    {
        $this->attributes['details'] = Crypt::encryptString($value);
    }
}
