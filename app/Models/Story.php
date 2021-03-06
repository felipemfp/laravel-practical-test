<?php

namespace App\Models;

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

    /**
     * Get the multimedias for the story.
     *
     * @return Illuminate\Support\Collection
     */
    public function multimedia() {
        return $this->hasMany('App\Models\Multimedia');
    }

    /**
     * Get the default thumbnail for the story.
     *
     * @return App/Models/Multimedia
     */
    public function thumb() {
        $thumb = $this->multimedia()->where('width', 75)->first();
        return $thumb;
    }

    /**
     * Get the facets for the story.
     *
     * @return Illuminate\Support\Collection
     */
    public function facets() {
        return $this->hasMany('App\Models\Facet');
    }
}
