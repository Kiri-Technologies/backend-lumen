<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setpoints extends Model
{
    protected $table = 'setpoints';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'route_id',
        'nama_lokasi',
        'lat',
        'long',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function route(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Routes::class, 'route_id', 'id');
    }
}
