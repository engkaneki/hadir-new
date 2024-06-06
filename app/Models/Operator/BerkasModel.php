<?php

namespace App\Models\Operator;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkasModel extends Model
{
    use HasFactory;

    protected $table = 'berkas';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
