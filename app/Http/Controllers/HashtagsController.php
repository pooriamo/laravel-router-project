<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;

class HashtagsController extends Controller
{
    public function index() {
        return Hashtag::all();
    }

    public function show($name) {
        $hashtag = Hashtag::where('name', $name)->first();

        if (!$hashtag) {
            return response()->json([], 404);
        }

        return $hashtag;
    }
}
