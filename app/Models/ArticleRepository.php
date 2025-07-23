<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleRepository extends Model
{
    protected $fillable = [
        'url',
        'meta',
    ];
}
