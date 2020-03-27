<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $year
 * @property string $award_img
 * @property string $award
 * @property int $liqueur_product_id
 * @property string $content
 * @property string $created_at
 * @property string $updated_at
 */
class LiqueurSure extends Model
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
    protected $fillable = ['img', 'contest', 'liqueur_product_id', 'year', 'award', 'created_at', 'updated_at'];

    public function liqueur_product()
    {
        return $this->belongsTo('App\LiqueurProduct', 'liqueur_product_id', 'id')->orderBy('sort', 'desc');
    }
}
