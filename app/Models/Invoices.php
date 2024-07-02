<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Documents;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'summary',
        'sale',
        'organization_id'
    ];

    public function document()
    {
        return $this->belongsTo(Documents::class, 'document_id');
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'invoice_product', 'invoice_id', 'product_id')->withPivot(['count', 'price', 'sale']);
    }
}
