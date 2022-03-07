<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Perjalanan extends Model
{
    protected $table = 'perjalanan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'penumpang_id',
        'angkot_id',
        'supir_id',
        'titik_naik',
        'titik_turun',
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
        return $this->hasMany(Feedback::class, 'perjalanan_id');
    }

    public function user_pengumpang(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function angkot(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Angkot::class, 'angkot_id', 'id');
    }

    public function user_supir(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'supir_id', 'id');
    }
}
