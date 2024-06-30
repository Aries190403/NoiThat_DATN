<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class picture extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'product_id', 'user_create', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_create');
    }
}
