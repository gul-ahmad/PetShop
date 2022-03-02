<?php

namespace Database\Seeders;

use App\Core\HelperFunction;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = [
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'This is the First Post ',
                'slug' => 'this-is-the-first-post',
                'content' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,
                 or randomised words which don't look even slightly believable",
                 'metadata' => [
                    'author'=> 'iron',
                    'image'=> '12345678'
                    ],
            ],
            [

                'uuid' => HelperFunction::_uuid(),
                'title' => 'This is the Second Post',
                'slug' => 'this-is-the-second-post',
                'content' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,
                 or randomised words which don't look even slightly believable",
                 'metadata' => [
                    'author'=> 'abc',
                    'image'=> '12345678'
                    ],

            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'This is the Third Post',
                'slug' => 'this-is-the-third-post',
                'content' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,
                or randomised words which don't look even slightly believable",
                'metadata' => [
                    'author'=> 'test',
                    'image'=> '12345678'
                    ],

            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'This is the fourth Post',
                'slug' => 'this-is-the-fourth-post',
                'content' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,
                or randomised words which don't look even slightly believable",
                'metadata' => [
                    'author'=> 'huio',
                    'image'=> '12345678'
                    ],

            ],
            [
                'uuid' => HelperFunction::_uuid(),
                'title' => 'This is the fifth Post',
                'slug' => 'this-is-the-fifth-post',
                'content' => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour,
                or randomised words which don't look even slightly believable",
                'metadata' => [
                   'author'=> 'tret',
                   'image'=> '12345678'
                   ],

            ]

        ];
        // Store All Campuses in Database
        foreach ($posts as $item)
        {
            Post::create($item);
        }
    }
}
