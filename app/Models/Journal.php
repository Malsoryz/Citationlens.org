<?php

namespace App\Models;

use App\Models\ArticleRepository;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'name',
        'oai_path',
        'max_list_record',
        'bpress',
        'dspace',
    ];

    protected $casts = [
        'bpress' => 'boolean',
        'dspace' => 'boolean',
    ];

    public function articles()
    {
        return $this->hasMany(ArticleRepository::class);
    }
}
