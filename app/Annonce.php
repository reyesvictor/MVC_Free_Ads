<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    // public $timestamps = false;
    protected $fillable = ['titre', 'description', 'prix', 'user_id'];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function getTitreAttribute($value)
    {   
        return strtoupper($value);
    }
}


