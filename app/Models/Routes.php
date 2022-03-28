<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Routes extends Model
{
    protected $table = 'routes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_trayek',
        'titik_awal',
        'titik_akhir',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'route_id');
    }

    public function setpoints()
    {
        return $this->hasMany(Setpoints::class, 'route_id');
    }
}
