<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Survey extends Model
{
    use HasFactory;
    public $incrementing = false; // Non-incrementing primary key
    protected $keyType = 'string'; // Primary key type

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    protected $fillable = [
        'id',
        'user_id',
        'tahun_lulusan',
        'status_sekarang',
        'nama_perusahaan',
        'posisi',
        'lama_bekerja',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
