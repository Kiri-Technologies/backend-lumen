<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ListSupir extends Model
{
    protected $table = 'list_supir';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supir_id',
        'angkot_id',
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
