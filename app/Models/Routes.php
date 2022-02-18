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
        'angkot_id',
        'nama_trayek',
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
