<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $liqueur_id
 * @property string $img
 * @property string $content
 * @property string $title
 * @property string $capacity
 * @property string $density
 * @property string $color
 * @property string $aroma
 * @property string $body
 * @property string $taste
 * @property string $aftertaste
 * @property int $price
 * @property string $note
 * @property int $sort
 * @property string $created_at
 * @property string $updated_at
 */
class LiqueurProduct extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['liqueur_id', 'img', 'content', 'title', 'capacity', 'density', 'color', 'aroma', 'body', 'taste', 'aftertaste', 'price', 'note', 'sort', 'created_at', 'updated_at'];

    public function liqueur()
    {
        return $this->belongsTo('App\Liqueur', 'liqueur_id', 'id')->orderBy('sort', 'desc');
    }

}
