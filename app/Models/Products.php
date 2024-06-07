<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'unit',
        'description',
    ];

    public function invoices()
    {
        return $this->belongsToMany(Invoices::class, 'invoice_product', 'product_id', 'invoice_id')->withPivot('count');
    }
}
