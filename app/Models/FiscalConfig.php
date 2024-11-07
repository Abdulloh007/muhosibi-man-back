<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiscalConfig extends Model
{
    use HasFactory;

    protected $table = "fiscal_config";

    protected $fillable = ['organization_id', 'server', 'port'];

    /**
     * Get the organization that owns the fiscal configuration.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
