<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
  use HasFactory;
  protected $guarded = [];


  /***************************************************************
   * 
   * ★hasManyメソッド★
   * 
   * 第一引数:リレーション先の従テーブル
   * 第二引数:主テーブルidと紐づける従テーブルのidカラム
   * 
   * 1対多のリレーションをしている
   * 主テーブルから従テーブルのレコードを取得している
   * 
   * 主テーブルが従テーブルのsection_idの情報を
   * 複数持つことができることが特徴
   * 
   *************************************************************/

  public function lectures()
  {
    return $this->hasMany(CourseLecture::class, 'section_id');
  }
}
