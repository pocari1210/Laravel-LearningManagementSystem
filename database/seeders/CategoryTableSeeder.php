<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class CategoryTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('categories')->insert([

      [
        'id' => 1,
        'category_name' => 'PHP',
        'category_slug' => 'php',
        'image' => '/upload/category/1727567758643597.png',
      ],

      [
        'id' => 2,
        'category_name' => 'python',
        'category_slug' => 'python',
        'image' => '/upload/category/1727567704776550.png',
      ],

      [
        'id' => 3,
        'category_name' => 'C言語',
        'category_slug' => 'c言語',
        'image' => '/upload/category/1727510078591020.png',
      ],

      [
        'id' => 4,
        'category_name' => 'JAVA',
        'category_slug' => 'java',
        'image' => '/upload/category/1727514027624366.png',
      ],

      [
        'id' => 5,
        'category_name' => 'javascript',
        'category_slug' => 'javascript',
        'image' => '/upload/category/1727510078591020.png',
      ],
    ]);
  }
}
