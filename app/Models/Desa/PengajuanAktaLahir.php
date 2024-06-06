<?php

namespace App\Models\Desa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanAktaLahir extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_akta_lahir';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
