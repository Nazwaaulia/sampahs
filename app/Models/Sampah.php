<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sampah extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kepala_keluarga',
        'nomor_rumah',
        'rt_rw',
        'total_karung_sampah',
        'kriteria',
        'tanggal_pengangkutan'
    ];
}
