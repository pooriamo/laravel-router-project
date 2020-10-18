<?php

namespace Database\Seeders;

use App\Models\Hashtag;
use Illuminate\Database\Seeder;

class HashtagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'cool',
            'pretty',
            'nice',
            'pro',
            'crypto',
        ];

        foreach ($names as $name) {
            Hashtag::create([
                'name'  => $name
            ]);
        }
    }
}
