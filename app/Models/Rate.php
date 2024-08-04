<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rate extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'content', 'quanlity', 'status'];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
