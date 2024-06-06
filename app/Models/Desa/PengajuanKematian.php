<?php

namespace App\Models\Desa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanKematian extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_kematian';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
