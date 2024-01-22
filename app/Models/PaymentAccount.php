<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model 
{
    use HasFactory;

    protected $fillable = [
        'number',
        'BIC',
        'сorrespondent_account', 
        'comments',
        'status',
    ];

    protected $casts = [
        'number' => 'integer',
    ];
}
