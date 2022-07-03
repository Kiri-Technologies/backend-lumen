<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'targets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'input',
        'target',
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

}
