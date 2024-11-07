<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = "currency";

    protected $fillable = [
        'name',
        'sh_name',
        'code',
        'well',
    ];

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }
}
