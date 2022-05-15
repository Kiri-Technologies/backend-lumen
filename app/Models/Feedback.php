<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'perjalanan_id',
        'rating',
        'review',
        'komentar',
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

    public function trip(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Trip::class, 'perjalanan_id', 'id');
    }
}
