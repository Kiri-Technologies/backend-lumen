<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes;
    protected $table = 'trips';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'penumpang_id',
        'angkot_id',
        'history_id',
        'tempat_naik_id',
        'tempat_turun_id',
        'supir_id',
        'nama_tempat_naik',
        'nama_tempat_turun',
        'jarak',
        'rekomendasi_harga',
        'is_done',
        'is_connected_with_driver',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'perjalanan_id');
    }

    public function user_penumpang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'penumpang_id', 'id');
    }

    public function vehicle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'angkot_id', 'id');
    }

    public function user_supir(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'supir_id', 'id');
    }
}
