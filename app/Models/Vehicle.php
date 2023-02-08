<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_plate',
        'color',
        'brand',
        'type',
        'owner_id',
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\Owner');
    }

    public function drivers()
    {
        return $this->belongsToMany('App\Models\Driver');
    }

    public function getTypeAttribute()
    {
        return ($this->attributes['type'] === "private") ? "Privado" : "Público";
    }
}
