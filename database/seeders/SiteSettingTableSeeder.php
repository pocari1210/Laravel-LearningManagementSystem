<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SiteSettingTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    DB::table('site_settings')->insert([

      [
        'id' => 1,
        'logo' => '/upload/logo/logo.png',
        'phone' => '電話番号を入力してください',
        'email' => 'メールアドレスを入力してください',
        'address' => '住所を入力してください',
        'facebook' => 'facebookのURLを入力してください',
        'twitter' => 'twitterのURLを入力してください',
        'copyright' => 'copyrightを入力してください',

      ],
    ]);
  }
}
