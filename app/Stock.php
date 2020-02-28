<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    protected $fillable = [
        'id',
        'imei',
        'sim',
        'equipment',
        'lost',
        'line',
        'office_guide',
        'sku',
        'color', 
        'trash'
    ];
    
}
