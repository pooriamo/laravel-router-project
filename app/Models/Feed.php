<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Builder;

class Feed extends Model {
    public function hashtags() {
        return $this->belongsToMany(Hashtag::class);
    }

    public function scopeHavingHashtag(Builder $query, $name) {
        return $query->whereHas('hashtags',  function (Builder $query) use ($name) {
            $query->where('name', $name);
        });
    }
}
