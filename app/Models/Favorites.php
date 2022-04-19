<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $table = 'favorites';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'route_id',
        'tempat_naik_id',
        'tempat_turun_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function route(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Routes::class, 'route_id', 'id');
    }

    public function setpoint_naik(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Setpoints::class, 'tempat_naik_id', 'id');
    }

    public function setpoint_turun(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Setpoints::class, 'tempat_turun_id', 'id');
    }
}
