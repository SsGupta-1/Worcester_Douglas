<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'screen_type',
        'caption',
        'file',
        'created_by',
        'created_at',
        'updated_at',
    ];
}
