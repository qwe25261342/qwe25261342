<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiqueurImg extends Model
{
    protected $table = 'liqueur_imgs';
    protected $fillable = [
        'id', 'liqueur_id', 'img', 'sort',
    ];
}
