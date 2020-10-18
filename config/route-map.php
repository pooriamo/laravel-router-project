<?php

// Here we define the relationship between paths and their corresponding host
// The key is the regex that the path should be tested against
return [
    'feed($|\/.*)'  => env('FEED_SITE'),
    'hashtags($|\/.*)'  => env('HASHTAGS_SITE'),
];
