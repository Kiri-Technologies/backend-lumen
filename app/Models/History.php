<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    protected $table = 'histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'angkot_id',
        'jumlah_pendapatan',
        'waktu_narik',
        'selesai_narik',
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

    public function vehicle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'angkot_id', 'id');
    }

    public function scopeFilter($query, array $filters){

        // fungsi untuk memfilter data tabel berdasarkan angkot_id pada tabel history
        $query->when($filters['angkot_id'] ?? false, function($query, $angkot_id) {
            return $query->where('angkot_id', 'like', '%'. $angkot_id. '%');
        });

        // fungsi untuk memfilter data tabel users berdasarkan supir_id
        $query->when($filters['supir_id'] ?? false, function($query, $supirId) {

            // disini 'supir' akan di ubah menjadi user sesuai method supir() yang sudah aku buat
            return $query->whereHas('supir', function($query) use ($supirId){
                $query->where('id', $supirId);
            });

        });
    }

    // menghubungkan tabel history dengan users dengan perantara 'users_id'
    // method supir() biar nanti saat di query yang muncul data nya adalah supir:{}
    public function supir(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
