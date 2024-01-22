<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrepreneurship extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4();
        });
    }


    protected $fillable = [
        'user_id',
        'reason',
        'location',
        'entr_form',
        'sector',
        'product',
        'num_employees',
        'capital_status',
        'workforce_fac',
        'start_time',
        'ent_count',
        'chg_reason',
        'working_hours',
        'income_amount',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
