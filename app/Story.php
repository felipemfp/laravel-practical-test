<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'abstract', 'section', 'subsection', 'url', 'short_url',
        'byline', 'updated_date', 'created_date', 'published_date'
    ];

    public function multimedia() {
        return $this->hasMany('App\Multimedia');
    }

    public function thumb() {
        $thumb = $this->multimedia()->where('width', 75)->first();
        return $thumb;
    }

    public function facets() {
        return $this->hasMany('App\Facet');
    }
}
