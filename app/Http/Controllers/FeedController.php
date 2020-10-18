<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FeedController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', [
            'only'  => ['store']
        ]);
    }

    public function index() {
        return Feed::all();
    }

    public function indexByHashtag($hashtag) {
        return Feed::havingHashtag($hashtag)->get();
    }

    public function store(Request $request) {
        $feed = Feed::create([
            'title' => $request->input('title'),
            'content'   => $request->input('content')
        ]);

        if ($request->hashtag) {
            $hashtag = Hashtag::where('name', $request->hashtag)->firstOrCreate([
                'name'  => $request->hashtag
            ]);;

            if ($hashtag) {
                $feed->hashtags()->attach($hashtag->id);
            }
        }

        return $feed;
    }
}
