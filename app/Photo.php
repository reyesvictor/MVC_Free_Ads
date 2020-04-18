<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    // protected $fillable = ['path', 'annonce_id'];
    public $timestamps = false;
    protected $guarded = [];

    public function annonce()
    {
        return $this->belongsTo(Annonce::class);
    }
 
}
