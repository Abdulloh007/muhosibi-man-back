<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\Node\Block\Document;

class DocGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'comment',
        'status'
    ];

    public function docs() {
        return $this->hasMany(Document::class, 'doc_group_id');
    }
}
