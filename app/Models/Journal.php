<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'name',
        'oai_path',
        'max_list_record',
        'bpress',
        'eprint',
    ];

    protected $casts = [
        'bpress' => 'boolean',
        'eprint' => 'boolean',
    ];
}
