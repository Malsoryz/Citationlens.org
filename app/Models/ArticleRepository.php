<?php

namespace App\Models;

use App\Models\Journal;
use Illuminate\Database\Eloquent\Model;

class ArticleRepository extends Model
{
    protected $fillable = [
        'url',
        'meta',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }
}
