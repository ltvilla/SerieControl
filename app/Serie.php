<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    public $timestamps = false;
    protected $fillable = ['nome', 'user_id', 'capa'];

    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }
}
