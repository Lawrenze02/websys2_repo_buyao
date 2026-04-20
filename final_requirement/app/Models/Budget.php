<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'monthly_limit',
        'month',
        'year',
    ];

    protected $casts = [
        'monthly_limit' => 'decimal:2',
        'month'         => 'integer',
        'year'          => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
