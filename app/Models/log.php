<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    use HasFactory;
    protected $fillable = ['user_create','supplier_id' , 'product_id', 'description', 'status'];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_create');
    }

    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(supplier::class, 'supplier_id');
    }
}
