<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
  use HasFactory;
  protected $guarded = [];

  /**********************************************************************
   * 
   * belongsToメソッド
   * 
   * 第一引数:主テーブルの指定
   * 第二引数:従テーブルのid(主テーブルと紐づける予定のカラム)
   * 第三引数:主テーブルのキーカラム
   * 
   * belongsToで従テーブル(SubCategory)から主テーブル(Category)の
   * レコードを取り出している
   * 
   ***********************************************************************/

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id', 'id');
  }
}
