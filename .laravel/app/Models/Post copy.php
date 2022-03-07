<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

class Post 
{

    private static $blog_post = [
        [
            "title" => "Judul Pertama",
            "slug" =>  "judul-pertama",
            "author" => "eris",
            "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, dolorem aperiam suscipit aspernatur blanditiis doloribus deleniti! Maiores velit nam corrupti cupiditate. Odit illo iusto dicta voluptas nemo esse quam aliquid.",
        ],
        [
            "title" => "Judul Kedua",
            "slug" => "judul-kedua",
            "author" => "wahyu",
            "body" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, dolorem aperiam suscipit aspernatur blanditiis doloribus deleniti! Maiores velit nam corrupti cupiditate. Odit illo iusto dicta voluptas nemo esse quam aliquid.",
        ]
    ];
    
    public static function all(){
        return collect(self::$blog_post);
    }

    public static function find($slug){
        $posts = static::all();

        return $posts->firstWhere("slug", $slug);
    }
}
