<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\Hashtag;
use Illuminate\Http\Request;

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
        return Feed::with('hashtags')->get();
    }

    public function indexByHashtag($hashtag) {
        return Feed::havingHashtag($hashtag)->get();
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'content'   => 'required'
        ]);

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
