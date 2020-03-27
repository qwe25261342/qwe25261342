<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiqueurStory extends Model
{
    protected $table = 'liqueur_stroys';
    protected $fillable = [
        'id', 'liqueur_id', 'img', 'content', 'title', 'sort',
    ];
    public function name()
    {
        return $this->belongsTo('App\Liqueur', 'liqueur_id', 'id')->orderBy('sort', 'desc');
    }
}
