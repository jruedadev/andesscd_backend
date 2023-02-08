<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_document',
        'document',
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'phone',
        'city',
    ];

    public function vehicle()
    {
        return $this->hasOne('App\Models\Vehicle');
    }
}
