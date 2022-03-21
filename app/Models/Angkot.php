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
        'user_id',
        'route_id',
        'plat_nomor',
        'qr_code',
        'pajak_tahunan',
        'pajak_stnk',
        'kir_bulanan',
        'is_beroperasi',
        'supir_id',
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

    public function list_supir()
    {
        return $this->hasMany(ListSupir::class, 'angkot_id');
    }

    public function perjalanan()
    {
        return $this->hasMany(ListSupir::class, 'angkot_id');
    }

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'angkot_id');
    }

    public function user_owner(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function route(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Routes::class, 'route_id', 'id');
    }

    public function user_supir(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'supir_id', 'id');
    }
}
