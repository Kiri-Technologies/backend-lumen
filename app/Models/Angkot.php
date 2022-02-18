<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Angkot extends Model
{
    protected $table = 'angkot';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'supir_id',
        'route_id',
        'plat_nomor',
        'qr_code',
        'pajak_tahunan',
        'pajak_stnk',
        'kir_bulanan',
        'is_beroperasi',
        'status',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];
}
