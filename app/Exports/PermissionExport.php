<?php

namespace App\Exports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PermissionExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    // Permissionテーブルのnameとgroupnameのカラムを取得
    return Permission::select('name', 'group_name')->get();
  }

  public function headings(): array
  {
    return [
      'name',
      'group_name',
    ];
  }
}
