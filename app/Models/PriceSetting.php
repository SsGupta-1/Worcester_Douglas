<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'price_type',
        'rang',
        'price_extension',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
