<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Serie extends Model
{
    public $timestamps = false;
    protected $fillable = ['nome', 'user_id', 'capa'];

    public function getCapaUrlAttribute()
    {
        if ($this->capa) {
            return Storage::url($this->capa);
        }

        return Storage::url('serie/semImagem.jpg');
    }   

    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }
}
