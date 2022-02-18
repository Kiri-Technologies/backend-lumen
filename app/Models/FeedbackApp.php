<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FeedbackApp extends Model
{
    protected $table = 'feedback_app';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'review',
        'tanggapan',
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
