<?php

namespace App\Models;

class Hashtag extends Model {
    public function feed() {
        return $this->belongsToMany(Feed::class);
    }
}
