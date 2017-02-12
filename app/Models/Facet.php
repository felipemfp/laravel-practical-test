<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facet extends Model
{
    const GEO = 'GEO';
    const DES = 'DES';
    const PER = 'PER';
    const ORG = 'ORG';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value', 'type', 'story_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'story_id'
    ];
}
