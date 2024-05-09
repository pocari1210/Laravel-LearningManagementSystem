<?php

namespace App\Exports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;

class PermissionExport implements FromCollection
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    // Permissionテーブルのnameとgroupnameのカラムを取得
    return Permission::select('name', 'group_name')->get();
  }
}
