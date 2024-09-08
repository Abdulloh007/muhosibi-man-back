<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'parent_id',
        'operation',
        'is_group',
        'dual_code',
        'penta_code',
    ];

    protected $casts = [
        'is_group' => 'boolean'
    ];
}
