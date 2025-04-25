<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrdKaryawan extends Model
{
    protected $connection = 'sqlsrv_hrd';
    protected $table = 'hrd_karyawan';

    public function user()
    {
        return $this->hasOne(User::class, 'kd_karyawan', 'KD_KARYAWAN');
    }
}
