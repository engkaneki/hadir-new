<?php

namespace App\Models\Desa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanSuratPindah extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat_pindah';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
