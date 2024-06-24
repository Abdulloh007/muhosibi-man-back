<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDocType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'operation'
    ];

    protected $casts = [
        'is_group' => 'boolean'
    ];
}
