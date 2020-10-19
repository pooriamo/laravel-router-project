<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */
/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;

/**
 * Handles same behavior for all http verbs
 * @param $url
 * @param $callback
 */
$any = function ($url, $callback) use ($router) {
    $router->get($url, $callback);
    $router->post($url, $callback);
    $router->put($url, $callback);
    $router->patch($url, $callback);
    $router->delete($url, $callback);
};

/**
 * The two route groups below represent separate sites for feed and hashtags.
 * Meaning that they don't belong in here. Just here for test
 */
$router->group([ 'prefix' => 'feed-site' ], function () use ($router, $any) {
    $router->get('/feed', 'FeedController@index');
    $router->get('/feed/{hashtag}', 'FeedController@indexByHashtag');
    $router->post('/feed', 'FeedController@store');

    $any('/{route:.*}', function () {
        return response()->json([
            'message'   => 'route not found'
        ], 404);
    });
});

$router->group([ 'prefix' => 'hashtags-site' ], function () use ($router, $any) {
    $router->get('/hashtags', 'HashtagsController@index');
    $router->get('/hashtags/{name}', 'HashtagsController@show');

    $any('/{route:.*}', function () {
        return response()->json([
            'message'   => 'route not found'
        ], 404);
    });
});

// Here is the catch-all route for our router (proxy) service:

/**
 * Returns the actual host of the given path based on regular expressions
 * @param $path
 * @return string|null
 */
function map($path) {
    foreach (config('route-map') as $key => $dest) {
        if (preg_match("/$key/", $path)) {
            return $dest . '/' . $path;
        }
    }

    return null;
}

$router->post('login', 'AuthController@login');
$router->post('logout', 'AuthController@logout');

$any('/{route:.*}', function (Request $request) {
    // find the actual host for this path
    $path = map($request->path());

    // return 404 if it's not found
    if (is_null($path)) {
        return response()->json([
            'message'   => 'route not found.'
        ], 404);
    }

    $client = new GuzzleHttp\Client([
        'timeout'   => 40 // 40 seconds
    ]);
    try {
        $res = $client->request(
            $request->method(),
            $path,
            [
                'json' => $request->all(),
                'headers' => $request->header()
            ]
        );

        return $res->getBody();
    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], $e->getCode());
    }
});


