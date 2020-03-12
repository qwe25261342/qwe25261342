<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTypes extends Model
{
    protected $table = 'Product_type';

    protected $fillable = [
       'title','sort'
    ];

}
