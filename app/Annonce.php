<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    public $timestamps = false;
    protected $fillable = ['titre', 'description', 'prix', 'user_id'];
    //
}


