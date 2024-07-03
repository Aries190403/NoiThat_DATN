<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coupon extends Model
{
    use HasFactory;
    protected $fillable = ['user_create', 'code', 'limit', 'count_active', 'discount', 'discount_money', 'downtime', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_create');
    }
}
