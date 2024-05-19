<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SubCategoryTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('sub_categories')->insert([

      [
        'id' => 1,
        'category_id' => '1',
        'subcategory_name' => 'Laravel',
        'subcategory_slug' => 'laravel',
      ],

      [
        'id' => 2,
        'category_id' => '1',
        'subcategory_name' => 'CakePHP',
        'subcategory_slug' => 'cakephp',
      ],

      [
        'id' => 3,
        'category_id' => '1',
        'subcategory_name' => 'FuelPHP',
        'subcategory_slug' => 'fuelphp',
      ],

      [
        'id' => 4,
        'category_id' => '2',
        'subcategory_name' => 'Django',
        'subcategory_slug' => 'django',
      ],

      [
        'id' => 5,
        'category_id' => '2',
        'subcategory_name' => 'Bottle',
        'subcategory_slug' => 'bottle',
      ],

      [
        'id' => 6,
        'category_id' => '2',
        'subcategory_name' => 'Flask',
        'subcategory_slug' => 'flask',
      ],

      [
        'id' => 7,
        'category_id' => '4',
        'subcategory_name' => 'Struts',
        'subcategory_slug' => 'struts',
      ],

      [
        'id' => 8,
        'category_id' => '4',
        'subcategory_name' => 'Spark Framework',
        'subcategory_slug' => 'spark-framework',
      ],

      [
        'id' => 9,
        'category_id' => '4',
        'subcategory_name' => 'JavaServer Faces',
        'subcategory_slug' => 'javaserver-faces',
      ],

      [
        'id' => 10,
        'category_id' => '4',
        'subcategory_name' => 'Play Framework',
        'subcategory_slug' => 'play-framework',
      ],

      [
        'id' => 11,
        'category_id' => '5',
        'subcategory_name' => 'React.js',
        'subcategory_slug' => 'react.js',
      ],

      [
        'id' => 12,
        'category_id' => '5',
        'subcategory_name' => 'Vue.js',
        'subcategory_slug' => 'vue.js',
      ],

      [
        'id' => 13,
        'category_id' => '5',
        'subcategory_name' => 'Jquery',
        'subcategory_slug' => 'jquery',
      ],




    ]);
  }
}
