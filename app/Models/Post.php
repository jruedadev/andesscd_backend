<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'short_description',
        'banner',
    ];

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
